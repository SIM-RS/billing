<?php 
include("../koneksi/konek.php");
//$qstr_cost="par=id_cost*kode_cost*cost_nama*parent_lvl";
$qstr_ma="par=idma*kode_ma*ma*tipecc*idcc*cc";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;

$th=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$th);

$idtr=$_REQUEST['idtr'];
$id_cost=0;
$idrba1=$_REQUEST['idrba1'];
$id_detil=$_REQUEST['id_detil'];
$jTrans=$_REQUEST['jTrans'];
$jBeban=$_REQUEST['jBeban'];
$idma=$_REQUEST['idma'];
$kode_ma=$_REQUEST['kode_ma'];
$tipecc=$_REQUEST['tipecc'];
$idcc=$_REQUEST['idcc'];
$dk=$_REQUEST['dk'];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
$tgl4=$_REQUEST['tgl'];$tgl4=explode("-",$tgl4);
$tgl=$tgl4[2]."-".$tgl4[1]."-".$tgl4[0];
$uraian=$_REQUEST['uraian'];
$nilai=$_REQUEST['nilai'];
$j_trans=0;
$ket_sak=$_REQUEST['ket_sak'];

$page=$_REQUEST["page"];
$defaultsort="tgl";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "edit":
			$sql="SELECT * FROM ma_sak WHERE MA_ID='$idma' AND CC_RV_KSO_PBF_UMUM=1";
			//echo $sql.";<br>";
			$rsCek=mysql_query($sql);
			if (mysql_num_rows($rsCek)<=0){
				$jBeban=0;
			}
			$sql="update detil_transaksi set fk_jenis_trans=$jTrans, fk_ma_sak=$idma, dk='$dk', ket='$ket_sak', cc_rv_kso_pbf_umum='$tipecc', id_cc_rv_kso_pbf_umum='$idcc',fk_ms_beban_jenis='$jBeban' where id_detil_trans=$id_detil";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
//		mysql_free_result($rs1);
		break;
	case "save":
	//asli->	$sql="select * from jurnal where no_kw='$nokw' and fk_cost='$id_cost'";
		/*$sql="select * from detil_transaksi where fk_jenis_trans=$jTrans and fk_ma_sak=$idma";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Transaksi Dengan Jenis Transaksi Tersebut Sudah Ada');</script>";
		}else{*/
			$sql="SELECT * FROM ma_sak WHERE MA_ID='$idma' AND CC_RV_KSO_PBF_UMUM=1";
			//echo $sql.";<br>";
			$rsCek=mysql_query($sql);
			if (mysql_num_rows($rsCek)<=0){
				$jBeban=0;
			}

			$sql="insert into detil_transaksi(fk_jenis_trans,fk_ma_sak,dk,ket,cc_rv_kso_pbf_umum,id_cc_rv_kso_pbf_umum,fk_ms_beban_jenis) values($jTrans,$idma,'$dk','$ket_sak',$tipecc,$idcc,'$jBeban')";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
		//}
		//mysql_free_result($rs1);
		break;
	case "delete":
		$sql="delete from detil_transaksi where id_detil_trans=$id_detil";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Transaksi Jurnal</title>
<link href="../theme/simkeu.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 500px; visibility: hidden">
</iframe>

<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 500px; visibility: hidden">
</iframe>
<div align="center">
	<form name="form1" method="post" action="">
	<input name="act" id="act" type="hidden" value="save">
	<input name="id_detil" id="id_detil" type="hidden" value="">
	<input name="parent_lvl" id="parent_lvl" type="hidden" value="">
  	<input name="mainduk" id="mainduk" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
<div id="input" style="display:none">
<table width="790" border="0" cellspacing="0" cellpadding="0" class="txtinput">
	<tr> 
	  <td colspan="4" class="jdltable">Setup Jurnal</td>
	</tr>
  <tr height="50">
  <td>&nbsp;</td>
    <td class="txtinput">Nama Jns.Transaksi</td>
	<td>:</td>
	<td> 
	  <input type="hidden" readonly="true" name="jTrans" id="jTrans" value="<?=$_GET[jurnal];?>">
      <input type="hidden" readonly="true" name="jBeban" id="jBeban" value="<?=$_GET[jbeban_id];?>">
	  <?
	  		$sqlTrans="SELECT JTRANS_NAMA from JENIS_TRANSAKSI where JTRANS_ID=".$_GET[jurnal];
			$exeTrans = mysql_query ($sqlTrans);
			while($showTrans=mysql_fetch_array($exeTrans)){
	  ?>
	  <input type="text" size="67" readonly="true" value="<?=$showTrans[JTRANS_NAMA];?>"> 
	  <? }?>	</td>
	</tr>
	<tr>
    <td>&nbsp;</td>
    <td width="130">Nama Rekening </td>
	<td width="10">:</td>
	<td>
	<input name="idma" type="hidden" id="idma" class="txtinput" value="<?php echo $idma; ?>" />
	<input name="kode_ma" type="text" id="kode_ma" class="txtinput" size="20" maxlength="20" readonly="true" value="<?php echo $kode_ma; ?>" /> 
        <input type="button" name="Button" value="..." class="txtcenter" onclick="OpenWnd('tree_ma_sak_view.php?<?php echo $qstr_ma; ?>',800,500,'mskg',true)" />	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td width="10">&nbsp;</td>
	    <td><textarea name="ma" cols="65" rows="3" readonly="true" id="ma" class="txtinput"><?=$ma?></textarea></td>
  </tr>
  <tr id="trcc" style="visibility:collapse">
    <td>&nbsp;</td>
    <td id="lblcc">Cost/Revenue Center</td>
    <td>&nbsp;</td>
    <td><input name="tipecc" type="hidden" id="tipecc" class="txtinput" value="" /><input name="idcc" type="hidden" id="idcc" class="txtinput" value="" /><input name="cc" id="cc" size="45" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Keterangan</td>
	<td width="10">&nbsp;</td>
	    <td><input name="ket_sak" id="ket_sak" size="45" /></td>
  </tr>
    <td>&nbsp;</td>
        <td>Debet / Kredit</td>
	<td width="10">:</td>
	<td>
	<select name="dk" id="dk">
		<option value="D">Debet</option>
		<option value="K"> Kredit </option>
	</select>	</td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td width="10">&nbsp;</td>
    <td height="40" valign="bottom">
        <BUTTON type="button" onClick="if (ValidateForm('jTrans,kode_ma','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
         <BUTTON type="reset" onClick="document.getElementById('act').value='save';document.getElementById('listjurnal').style.display='block';document.getElementById('input').style.display='none'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Batal</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>	</td>
  </tr>
</table>
</div>
<!-- Ending Transaksi Jurnal -->
<div id="listjurnal" style="display:block">
      <span class="jdltable">Detail Jenis Transaksi  
      <label> </label>
      </span><br>
  <table width="99%" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td colspan="8"></td>
      </tr>
    <tr> 
      <td colspan="2" class="txtinput" style="text-align:right">Pilih Jenis Transaksi : &nbsp;
	  <!--select name="jurnal" id="jurnal" style="width:400px"onChange="location='?f=detail&jurnal='+this.value"> 
			<option value="">
			<?php 
			$sql1="SELECT JTRANS_NAMA from JENIS_TRANSAKSI where JTRANS_ID=".$_GET[jurnal];
			$exe1 = mysql_query ($sql1);
			$show1=mysql_fetch_array($exe1);
			if ($_GET[jurnal]==0){
				echo "Silahkan Pilih Jenis Transaksi";
			}else{
				echo "$show1[JTRANS_NAMA]";
			}
			
			$sql1="SELECT id,nama from ak_ms_beban_jenis where id=".$_GET[jbeban_id];
			$rsBeban = mysql_query($sql1);
			$showBeban=mysql_fetch_array($rsBeban);
			?>
			</option>
			<?php
			$sqlTrans="SELECT JTRANS_ID, JTRANS_NAMA from JENIS_TRANSAKSI";
			$exeTrans = mysql_query ($sqlTrans);
			while($showTrans=mysql_fetch_array($exeTrans)){
			?>
			<option value="<?=$showTrans[JTRANS_ID];?>"><?=$showTrans[JTRANS_NAMA];?></option>
			<? }?>
        </select-->
		</td>
        <td colspan="2" class="txtinput">
            <input type="text" size="65" value="<?=$show1[JTRANS_NAMA]?>" readonly="true" />
            <input type="button" value=".." onclick="OpenWnd('tree_jTrans2.php',800,500,'msma',true)" /><br />
        </td>
		<td colspan="3" align="right"><!--BUTTON type="button" <? if($_GET[jurnal]==0) {echo "disabled='disabled'";}?> onClick="document.getElementById('input').style.display='block';document.getElementById('listjurnal').style.display='none';"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Tambah</strong></BUTTON-->
		</td>
    </tr>
    <tr> 
      <td colspan="2" class="txtinput" style="text-align:right">Pilih Jenis Beban : &nbsp;
		</td>
        <td colspan="2" class="txtinput">
            <input type="text" size="65" value="<?=$showBeban[nama]?>" readonly="true" />
            <input type="button" value=".." onclick="OpenWnd('tree_jBeban.php?par=<?php echo $_GET[jurnal]; ?>',800,500,'msma',true)" />
        </td>
		<td colspan="3" align="right"><BUTTON type="button" <? if($_GET[jurnal]==0) {echo "disabled='disabled'";}?> onClick="document.getElementById('input').style.display='block';document.getElementById('listjurnal').style.display='none';"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Tambah</strong></BUTTON>
		</td>
    </tr>    <tr class="headtable"> 
          <td width="31" class="tblheaderkiri">No</td>
          <td id="kode_ma" width="157" class="tblheader" onClick="ifPop.CallFr(this);">No.Rek</td>
      <!-- <td id="kg_kode" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode Cost Center</td> -->
	      <td width="373" class="tblheader" id="ma" onClick="ifPop.CallFr(this);">Nama Rekening</td>
          <td id="ket" width="345" class="tblheader" onClick="ifPop.CallFr(this);">Keterangan</td>
          <td id="dk" width="101" class="tblheader" onClick="ifPop.CallFr(this);">Debet/Kredit</td>
      <td class="tblheader" colspan="2">Proses</td>
    </tr>
	  <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql=" SELECT *, detil_transaksi.fk_jenis_trans AS Expr1, MA_SAK.MA_KODE AS MA_SAK_KODE, MA_SAK.MA_NAMA AS MA_SAK_NAMA, JENIS_TRANSAKSI.JTRANS_NAMA AS Expr4, JENIS_TRANSAKSI.JTRANS_ID AS Expr5, detil_transaksi.fk_ma_sak AS Expr6, detil_transaksi.dk AS Expr7, detil_transaksi.id_detil_trans AS Expr8, detil_transaksi.*
FROM detil_transaksi INNER JOIN JENIS_TRANSAKSI ON detil_transaksi.fk_jenis_trans = JENIS_TRANSAKSI.JTRANS_ID INNER JOIN MA_SAK ON detil_transaksi.fk_ma_sak = MA_SAK.MA_ID WHERE JENIS_TRANSAKSI.JTRANS_ID=".$_GET[jurnal];
	  //echo $sql;
	  $rs=mysql_query($sql);
		$rs=mysql_query($sql);
		$jmldata=mysql_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  $trk=0;
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		/*if ($rows["cc_rv_kso_pbf_umum"]==1){
			$sql="SELECT * FROM ak_ms_unit WHERE id='".$rows["id_cc_rv_kso_pbf_umum"]."'";
			//echo $sql;
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$ket=$rw1["nama"];
		}*/
		$ket="";
		if ($rows["fk_ms_beban_jenis"]!=0){
			$sql="SELECT * FROM ak_ms_beban_jenis WHERE id='".$rows["fk_ms_beban_jenis"]."'";
			//echo $sql;
			$rs1=mysql_query($sql);
			$rw1=mysql_fetch_array($rs1);
			$ket=$rw1["nama"];		
		}
		//$sql="select * from ma_sak where MA_KODE=".$rows['Expr6'];
		//echo $sql;
		//$rs1=mysql_query($sql);
		$arfvalue="act*-*edit*|*kode_ma*-*".$rows['MA_KODE']."*|*ma*-*".$rows['MA_NAMA']."*|*id_detil*-*".$rows['Expr8']."*|*idma*-*".$rows['fk_ma_sak']."*|*dk*-*".$rows['dk']."*|*ket_sak*-*".$rows['ket'];
		$arfhapus="act*-*delete*|*id_detil*-*".$rows['Expr8'];
		?>
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
      <td class="tdisikiri"><?php echo $i; ?></td>
      <td class="tdisi"><?php echo $rows['MA_SAK_KODE']; ?></td>
	  <td class="tdisi"><?php echo $rows['MA_SAK_NAMA']; ?></td>
	  <td class="tdisi"><?php echo $ket;?>&nbsp;</td>
	  <td class="tdisi"><? if ($rows['dk']=='D'){ echo "Debet";}elseif ($rows['dk']=='K'){ echo "Kredit";}?></td>
          <td width="26" class="tdisi"><IMG SRC="../icon/edit.gif" border="0" width="16" height="16" ALIGN="absmiddle" class="proses" title="Klik Untuk Mengubah Data Transaksi" onClick="document.getElementById('input').style.display='block';document.getElementById('listjurnal').style.display='none';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
	      <td width="26" class="tdisi"><IMG SRC="../icon/del.gif" border="0" width="16" height="16" ALIGN="absmiddle" class="proses" title="Klik Untuk Menghapus Data Transaksi" onClick="<?php if ($status>0){?>alert('Transaksi Ini Sudah Dibuat SPJ-nya.\r\nJadi Data Tidak Boleh Dihapus.');<?php }else{?>if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}<?php }?>"></td>
    </tr>
	  <?php 
	  }
	  mysql_free_result($rs);
	  if ($page==$totpage)
	  {
	 // $sql="select isnull(sum(debit),0) as stotd,isnull(sum(kredit),0) as stotk from jurnal where month(tgl)=$bulan[0] and year(tgl)=$ta";
	  $rs=mysql_query($sql);
	  $stotd=0;
	  $stotk=0;	
	  if ($rows=mysql_fetch_array($rs))
	  	{
	  	$stotd=$rows["stotd"];
		$stotk=$rows["stotk"];	
	  	}
	  mysql_free_result($rs);
 	  }?>
      <tr> 
        <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="4" align="right">
		<img src="../icon/next_01.gif" border="0" width="32" height="32" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();">
		<img src="../icon/next_02.gif" border="0" width="32" height="32" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();">
		<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();">
		<img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	</td>
		</tr>
  </table>
<!--  <p><BUTTON type="button" onClick="window.open('../report/journal_print.php?bulan='+bulan.value+'&ta='+ta.value+'&idunit=<?php echo $idunit.'|'.$usrname; ?>')"<?php if ($i==0) echo " disabled";?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Cetak Detail Transaksi</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>-->
  </div>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>