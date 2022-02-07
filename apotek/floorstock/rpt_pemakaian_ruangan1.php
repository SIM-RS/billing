<?php 
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_REQUEST["idunit"];
$jdl="DAFTAR REKAP PENGIRIMAN OBAT KE RUANGAN/POLI";
if ($idunit==""){
	//$idunit=$_SESSION["ses_idunit"];
	$jdl="DAFTAR REKAP RESEP OBAT OLEH RUANGAN/POLI";
}
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$unit_tujuan=$_REQUEST['unit_tujuan']; if($unit_tujuan=="0" OR $unit_tujuan=="") $unit_tj=""; else $unit_tj="and a_penerimaan.UNIT_ID_TERIMA=$unit_tujuan";
$tgl_d=$_REQUEST['tgl_d'];if ($tgl_d=="") $tgl_d=$tgl;
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];if ($tgl_s=="") $tgl_s=$tgl;
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";
//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="a_penerimaan.ID desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" /><strong></strong>
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 200px; visibility: hidden">
</iframe>
<div align="center">
	  <p><span class="jdltable"><?php echo $jdl; ?></span></p> 
      <table width="49%" align="center" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
          <td width="150">Tanggal Periode</td>
          <td>: 
            <input name="tgl_d" type="text" id="tgl_d" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_d;?>" /> 
            <input type="button" name="Buttontgl_d" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tgl_d'),depRange);" />
            &nbsp;&nbsp;s/d&nbsp;&nbsp;
            <input name="tgl_s" type="text" id="tgl_s" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl_s;?>" > 
            <input type="button" name="Buttontgl_s" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tgl_s'),depRange);" />          </td>
        </tr>
        <tr>
          <td>Data Yang Ditampilkan</td>
          <td>:&nbsp;<select id="cmbdata" name="cmbdata">
          				<option value="0">Quantity</option>
                        <option value="1">Nilai Bahan</option>
          </select></td>
        </tr>
      </table>
<br />
    <table width="99%" align="center" border="0" cellpadding="1" cellspacing="0">
	 <td align="center"><BUTTON type="button" onClick="OpenWnd('../floorstock/rpt_pemakaian_ruangan_excell.php?idunit=<?php echo $idunit; ?>&nunit1=<?php echo $nunit1; ?>&tgl_d='+tgl_d.value+'&tgl_s='+tgl_s.value+'&cmbdata='+cmbdata.value,600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON></td>
		</tr>
		</table>
</div>
</body>
</html>
