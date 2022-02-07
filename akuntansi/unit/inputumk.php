<?php 
include("../koneksi/konek.php");

//$idunit=1;
$fromfile=$_REQUEST['fromfile'];
$noumk=$_REQUEST['noumk'];if ($noumk=="") $noumk="";
$idumk=$_REQUEST['idumk'];if ($idumk=="") $idumk="0";
$idrba=$_REQUEST['idrba'];if ($idrba=="") $idrba="0";
$idrba1=$_REQUEST['idrba1'];if ($idrba1=="") $idrba1="0";
//$idumkrinci=$_REQUEST['idumkrinci'];if ($idumkrinci=="") $idumkrinci="0";
$uraian=$_REQUEST['uraian'];
$nilai=$_REQUEST['nilai'];if ($nilai=="") $nilai="0";
$qty=$_REQUEST['qty'];if ($qty=="") $qty="0";
$subtot=$nilai*$qty;
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl3=gmdate('Y-m-d',mktime(date('H')+7));
//$tgl1=explode("-",$tgl);
$tgl1=explode("-","--2009");
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$tgl1[2];
$tglumk=$_REQUEST['tgl'];
if ($tglumk==""){
	$tglumk=$tgl3;
}else{
	$ctgl=explode("-",$tglumk);
	$tglumk=$ctgl[2]."-".$ctgl[1]."-".$ctgl[0];
}

$page=$_REQUEST["page"];
$defaultsort="kg_kode,ma_kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "saveumk":
		$sql="update umk set umk_periode='$tglumk',UMK_NO='$noumk' where umk_id=$idumk";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		break;
	case "save":
/*		$sql="select * from umk_rinci where RINCI_RBAID=$idrba and RINCI_UMKID=$idumk";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			
			echo "<script>alert('Kegiatan Tersebut Sudah Ada');</script>";
		}else{
*/			$sql="select * from umk_rinci where RINCI_UMKID=$idumk";
			//echo $sql;
			$rs2=mysql_query($sql);
			if (mysql_num_rows($rs2)<=0){
				$sql="insert into umk(umk_periode,umk_unitid,umk_status) values('$tgl3',$idunit,0)";
				//echo $sql."<br>";
				$rs3=mysql_query($sql);			
				$sql="select max(umk_id) as idumk from umk where umk_unitid=$idunit";
				//echo $sql."<br>";
				$rs3=mysql_query($sql);
				if ($rows3=mysql_fetch_array($rs3)) $idumk=$rows3["idumk"];
				mysql_free_result($rs3);			
			}
			mysql_free_result($rs2);
			$sql="insert into umk_rinci(rinci_umkid,rinci_rbaid,rinci_uraian,rinci_nilai,rinci_qty,rinci_subtotal) values($idumk,$idrba,'$uraian',$nilai,$qty,$subtot)";
			//echo $sql."<br>";
			$rs2=mysql_query($sql);
			$sql="update umk set umk.umk_total=(select sum(rinci_subtotal) from umk_rinci where rinci_umkid=$idumk) where umk_id=$idumk";
			//echo $sql."<br>";
			$rs2=mysql_query($sql);
//		}
//		mysql_free_result($rs1);
		break;
	case "edit":
		$sql="update umk_rinci set rinci_rbaid=$idrba,rinci_uraian='$uraian',rinci_nilai=$nilai,rinci_qty=$qty,rinci_subtotal=$subtot where rinci_umkid=$idumk and rinci_rbaid=$idrba1";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		$sql="update umk set umk.umk_total=(select sum(rinci_subtotal) from umk_rinci where rinci_umkid=$idumk) where umk_id=$idumk";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		break;
	case "delete":
		$sql="delete from umk_rinci where rinci_umkid=$idumk and rinci_rbaid=$idrba";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		$sql="update umk set umk.umk_total=(select sum(rinci_subtotal) from umk_rinci where rinci_umkid=$idumk) where umk_id=$idumk";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		break;
}
?>
<html>
<head>
<title>Pengajuan Uang Muka</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
    <input name="act" id="act" type="hidden" value="save">
	<input name="idrba" id="idrba" type="hidden" value="">
	<input name="idrba1" id="idrba1" type="hidden" value="">
	<input name="idumk" id="idumk" type="hidden" value="<?php echo $idumk; ?>">
	<input name="fromfile" id="fromfile" type="hidden" value="<?php echo $fromfile; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input name="filter" id="filter" type="hidden" value="<?php echo $filter; ?>">
	<div id="input" style="display:none">
      <table width="70%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td colspan="3" class="jdltable">Pengajuan Uang Muka</td>
        </tr>
        <tr> 
          <td width="120">Tahun Anggaran</td>
          <td width="5">:</td>
          <td><select name="ta" id="ta" class="txtinput">
              <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
              <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
              <?php }?>
            </select></td>
        </tr>
        <tr> 
          <td>Pilih Kegiatan</td>
          <td>:</td>
          <td><input name="kode_kg" type="text" id="kode_kg" size="25" maxlength="25" class="txtcenter" readonly="true"> 
            <input type="button" name="Button222" value="..." class="txtinput" title="Pilih Kegiatan Berdasarkan Kode Kegiatan" onClick="OpenWnd('../rba/rba_view.php?idunit=<?php echo $idunit; ?>&ta=<?php echo $ta; ?>&par=idrba*kode_kg',800,500,'mskegiatan',true)"></td>
        </tr>
        <tr> 
          <td>Uraian Kegiatan</td>
          <td>:</td>
          <td><textarea name="uraian" cols="50" rows="3" id="uraian"></textarea></td>
        </tr>
        <tr> 
          <td>Qty</td>
          <td>:</td>
          <td><input name="qty" type="text" id="qty" size="5" maxlength="5" class="txtcenter">
            (brg/org/kegiatan)</td>
        </tr>
        <tr> 
          <td>Nilai Satuan (Rp)</td>
          <td>:</td>
          <td><input name="nilai" type="text" id="nilai" size="15" maxlength="15" class="txtright"></td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><p> 
              <BUTTON type="button" onClick="if ((ValidateForm('kode_kg,uraian,uraian,qty,nilai','ind'))&&(fCekIsNaN('Nilai UMK,nilai'))){document.forms[0].submit()};"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><strong>&nbsp;Simpan</strong></BUTTON>
              <BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listumk').style.display='block';document.form1.act.value='save';"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle"><strong>&nbsp;Batal</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
            </p></td>
        </tr>
      </table>
	</div>
  <p><!--span class="jdltable">Kode-Nama Unit :01110-Graha ITS</span-->
  <table width="99%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
  <tr>
  	<td align="left">
	  <?php 
	  	$sql="select * from umk where umk_id=$idumk";
		$rs=mysql_query($sql);
		if ($rows=mysql_fetch_array($rs)){
			//$tgl=$rows["UMK_PERIODE"];
			//$ctgl=explode("-",$tgl);
			//$tgl=$ctgl[2]."-".$ctgl[1]."-".$ctgl[0];
			$noumk=$rows["UMK_NO"];
		}
		mysql_free_result($rs);
	  ?>
	  <div id="listumk" style="display:block">
            <div align="center"><span class="jdltable">Daftar Detail Uang Muka 
              Yang Diajukan</span><br>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr> 
        <td colspan="2" class="jdltable">&nbsp;</td>
		        <td colspan="3" class="jdltable">&nbsp;</td>
      	<td align="right" colspan="4"><BUTTON type="button" onClick="document.getElementById('input').style.display='block';document.getElementById('listumk').style.display='none'"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle"><strong>&nbsp;Tambah</strong></BUTTON></td>
	  </tr>
      <tr class="headtable"> 
        <td width="4%" class="tblheaderkiri">No</td>
        <td id="kg_kode" width="7%" class="tblheader" onClick="ifPop.CallFr(this);">Kode Kegiatan</td>
		<td id="ma_kode" width="7%" class="tblheader" onClick="ifPop.CallFr(this);">Kode MA</td>
        <td id="RINCI_URAIAN" width="58%" class="tblheader" onClick="ifPop.CallFr(this);">Uraian</td>
        <td width="5%" class="tblheader">Qty</td>
        <td width="130" class="tblheader">Satuan<br>
          (Rp)</td>
        <td id="RINCI_SUBTOTAL" width="130" class="tblheader" onClick="ifPop.CallFr(this);">Jumlah<br>
          (Rp)</td>
		<td class="tblheader" colspan="2">Proses</td>
      </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select row_number() over(order by ".$sorting.") as rownum,u.*,kg_kode,ma_kode from umk_rinci u inner join rba r on u.rinci_rbaid=r.rba_id inner join kegiatan k on r.rba_kgid=k.kg_id inner join ma on r.rba_maid=ma.ma_id where u.rinci_umkid=$idumk".$filter;
	  $sql="select u.rinci_rbaid from umk_rinci u inner join rba r on u.rinci_rbaid=r.rba_id inner join kegiatan k on r.rba_kgid=k.kg_id inner join ma on r.rba_maid=ma.ma_id where u.rinci_umkid=$idumk".$filter;
	  //echo $sql;
	  $rs=mysql_query($sql);
	  
	if ($page=="" || $page=="0") $page="1";
  	//$perpage=20;$tpage=($page-1)*$perpage+1;$ypage=$page*$perpage;
  	$perpage=20;$tpage=($page-1)*$perpage;
  	$jmldata=mysql_num_rows($rs);
  	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
  	if ($page>1) $bpage=$page-1; else $bpage=1;
  	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
  	//$sql="select t.* from (".$sql.") as t where t.rownum between $tpage and $ypage";
	$sql="select top $perpage u.*,kg_kode,ma_kode from umk_rinci u inner join rba r on u.rinci_rbaid=r.rba_id inner join kegiatan k on r.rba_kgid=k.kg_id inner join ma on r.rba_maid=ma.ma_id where u.rinci_umkid=$idumk and u.rinci_rbaid not in (select top $tpage u.rinci_rbaid from umk_rinci u inner join rba r on u.rinci_rbaid=r.rba_id inner join kegiatan k on r.rba_kgid=k.kg_id inner join ma on r.rba_maid=ma.ma_id where u.rinci_umkid=$idumk".$filter." order by ".$sorting.")".$filter." order by ".$sorting;
	//echo $sql."<br>";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";$stot=0;
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$tot=$rows['RINCI_SUBTOTAL'];
		$stot=$stot+$tot;
		$arfvalue="act*-*edit*|*kode_kg*-*".$rows['kg_kode']."*|*idrba1*-*".$rows['RINCI_RBAID']."*|*idrba*-*".$rows['RINCI_RBAID']."*|*uraian*-*".$rows['RINCI_URAIAN']."*|*qty*-*".$rows['RINCI_QTY']."*|*nilai*-*".$rows['RINCI_NILAI'];
	  	$arfhapus="act*-*delete*|*idrba*-*".$rows['RINCI_RBAID'];
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi"><?php echo $rows['kg_kode']; ?></td>
		<td class="tdisi"><?php echo $rows['ma_kode']; ?></td>
        <td align="left" class="tdisi"><?php echo $rows['RINCI_URAIAN']; ?></td>
        <td class="tdisi"><?php echo $rows['RINCI_QTY']; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['RINCI_NILAI'],0,",","."); ?></td>
        <td align="right" class="tdisi"><?php echo number_format($tot,0,",","."); ?></td>
		<td class="tdisi" width="30"><IMG SRC="../icon/edit.gif" border="0" width="16" height="16" ALIGN="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
		<td class="tdisi" width="30"><IMG SRC="../icon/del.gif" border="0" width="16" height="16" ALIGN="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
      </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  ?>
      <tr class="itemtable"> 
        <td colspan="6" align="right" class="tdisikiri">Total</td>
        <td align="right" class="tdisi"><?php echo number_format($stot,0,",","."); ?></td>
		<td class="tdisi" colspan="2">&nbsp;</td>
      </tr>
      <tr> 
        <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="2" align="right">&nbsp;</td>
		<td colspan="4" align="right">
		<img src="../icon/next_01.gif" border="0" width="32" height="32" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="32" height="32" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;
		</td>
      </tr>
	</table>
	<!--table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr> 
                <td align="center" valign="bottom" height="40">Pilih Unit Layanan : 
                  <select name="unit_bauk" id="unit_bauk">
				  <?php 
			/*	  $sql="select * from unit where jenis=4 and aktif=1";
				  $rs=mysql_query($sql);
				  while ($rows=mysql_fetch_array($rs)){
				  ?>
                    <option value="<?php echo $rows["UNIT_ID"]; ?>"><?php echo $rows["UNIT_NAMA"]; ?></option>
				  <?php 
				  }
				  mysql_free_result($rs);
			*/	  ?>
                  </select></td>
      </tr>
      <tr> 
        <td align="center" valign="bottom" height="30">&nbsp;&nbsp;
                  <BUTTON type="button" onClick="location='?f=saveumk.php&idumk=<?php //echo $idumk; ?>&noumk=<?php //echo $noumk; ?>&bauk='+unit_bauk.value;"><IMG SRC="../icon/ajukan.png" border="0" width="18" height="18" ALIGN="absmiddle">&nbsp;Ajukan 
                  UMK&nbsp;&nbsp;</BUTTON>
                  <BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="18" height="18" ALIGN="absmiddle">&nbsp;Cetak 
                  UMK &nbsp;</BUTTON>
		<?php //if ($fromfile!=""){?>
                  <BUTTON type="button" onClick="location='?f=<?php //echo $fromfile.".php"; ?>'"><IMG SRC="../icon/back.png" border="0" width="18" height="18" ALIGN="absmiddle">&nbsp;Kembali 
                  &nbsp;</BUTTON>
		<?php //}?>
		</td>
      </tr>
    </table-->
	<br>
	<table width="60%" border="0" cellpadding="0" cellspacing="0" class="txtinput" align="center">
	  <!--tr> 
		<td colspan="3" class="jdltable">Data Uang Muka</td>
	  </tr-->
	  <tr> 
		<td width="150">&nbsp;Tgl Pengajuan</td>
		<td width="10">:</td>
		<td><input name="tgl" type="text" id="tgl" size="11" maxlength="10" class="txtcenter" value="<?php echo $tgl; ?>" readonly="true"> 
		  <input type="button" name="Button2" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl,depRange);"></td>
	  </tr>
	  <tr> 
		<td>&nbsp;Tahun Anggaran</td>
		<td>:</td>
		<td><input name="thnanggaran" type="text" id="thnanggaran" size="4" maxlength="4" class="txtcenter" value="<?php echo $tgl1[2]; ?>" readonly="true"></td>
	  </tr>
	  <!--tr> 
<td>Unit Pengguna</td>
  <td>:</td>
<td><input name="unit" type="text" id="unit" value="Pengurus Graha ITS" size="50" maxlength="50" readonly="true"> 
</td>
</tr-->
	  <tr> 
		<td>&nbsp;No UMK</td>
		<td>:</td>
		<td><input name="noumk" type="text" id="noumk" size="25" maxlength="25" class="txtinput" value="<?php echo $noumk; ?>"></td>
	  </tr>
	  <tr>
	  	<td>&nbsp;Pilih Unit Layanan</td>
		<td>:</td>
		<td>
		  <select name="unit_bauk" id="unit_bauk" class="txtinput">
		  <?php 
		  $sql="select * from unit where jenis=4 and aktif=1";
		  $rs=mysql_query($sql);
		  while ($rows=mysql_fetch_array($rs)){
		  ?>
			<option value="<?php echo $rows["UNIT_ID"]; ?>"><?php echo $rows["UNIT_NAMA"]; ?></option>
		  <?php 
		  }
		  mysql_free_result($rs);
		  ?>
		  </select>		
		</td>
	  </tr>
	  <tr> 
		<td colspan="3" height="25">&nbsp;</td>
	  </tr>
	  <tr> 
		<!--td>&nbsp;</td>
		<td>&nbsp;</td-->
		<td colspan="3"> 
			<BUTTON type="button" onClick="if (ValidateForm('noumk','ind')){document.form1.act.value='saveumk';document.forms[0].submit()};"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle"><strong>&nbsp;Update</strong></BUTTON>
            <BUTTON type="button" onClick="if (ValidateForm('noumk','ind')){location='?f=saveumk.php&idumk=<?php echo $idumk; ?>&noumk=<?php echo $noumk; ?>&bauk='+unit_bauk.value;}"><IMG SRC="../icon/ajukan.png" border="0" width="16" height="16" ALIGN="absmiddle"><strong>&nbsp;Ajukan UMK</strong></BUTTON>
            <BUTTON type="button" onClick=""><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle"><strong>&nbsp;Cetak UMK</strong></BUTTON>
		<?php if ($fromfile!=""){?>
                  <BUTTON type="button" onClick="location='?f=<?php echo $fromfile.".php"; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle"><strong>&nbsp;Kembali</strong></BUTTON>
		<?php }?>
		  </td>
	  </tr>
	</table>
	</div>
	</td>
   </tr>
  </table>
  </p>
  </form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>