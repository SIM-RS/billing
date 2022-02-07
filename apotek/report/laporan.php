<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$th);
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST["bulan"];
if ($bulan==""){
	$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}
$id=$_REQUEST["id"];
$it=$_REQUEST["it"];
$iunit=$_REQUEST["iunit"];
if ($iunit==""){
	$iunit=$idunit."|".$usrname;
}else{
	$usrname=explode("|",$iunit);
	$usrname=$usrname[1];
}

$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "save":
		$sql="";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Transaksi Jurnal</title>
<link href="../theme/apotik.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div align="center">
<form name="form1" method="post">
  <input name="act" id="act" type="hidden" value="save">
  	<input name="idma" id="idma" type="hidden" value="">
  	<input name="parent_lvl" id="parent_lvl" type="hidden" value="">
<div id="input" style="display:block">
<?php if ($it=="1"){
$lnk="'../report/journal_print.php?bulan='+bulan.value+'&ta='+ta.value+'&idunit=$iunit'";
?>
	  <p class="jdltable">Laporan Jurnal Keuangan</p>
      <table width="250" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr> 
          <td width="100">Username</td>
          <td width="10">:</td>
          <td width="414"><?php echo strtoupper($username); ?></td>
        </tr>
        <tr> 
          <td>Bulan</td>
          <td width="10">:</td>
          <td><select name="bulan" id="bulan">
              <option value="1|Januari"<?php if ($bulan=="1") echo " selected";?>>Januari</option>
              <option value="2|Pebruari"<?php if ($bulan=="2") echo " selected";?>>Pebruari</option>
              <option value="3|Maret"<?php if ($bulan=="3") echo " selected";?>>Maret</option>
              <option value="4|April"<?php if ($bulan=="4") echo " selected";?>>April</option>
              <option value="5|Mei"<?php if ($bulan=="5") echo " selected";?>>Mei</option>
              <option value="6|Juni"<?php if ($bulan=="6") echo " selected";?>>Juni</option>
              <option value="7|Juli"<?php if ($bulan=="7") echo " selected";?>>Juli</option>
              <option value="8|Agustus"<?php if ($bulan=="8") echo " selected";?>>Agustus</option>
              <option value="9|September"<?php if ($bulan=="9") echo " selected";?>>September</option>
              <option value="10|Oktober"<?php if ($bulan=="10") echo " selected";?>>Oktober</option>
              <option value="11|Nopember"<?php if ($bulan=="11") echo " selected";?>>Nopember</option>
              <option value="12|Desember"<?php if ($bulan=="12") echo " selected";?>>Desember</option>
            </select> </td>
        </tr>
        <tr> 
          <td>Tahun</td>
          <td width="10">:</td>
          <td><select name="ta" id="ta">
              <?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
              <option value="<?php echo $i; ?>"<?php if ($i==$ta) echo " selected";?>><?php echo $i; ?></option>
              <?php }?>
            </select> </td>
        </tr>
      </table>
<?php }elseif ($it=="2"){
	$lnk="'../report/bukubesar_print.php?idma='+idma.value+'&kode_ma='+kode_ma.value+'&bulan='+bulan.value+'&ta='+ta.value+'&idunit=$iunit'";
	$qstr_ma="par=idma*kode_ma*ma*parent_lvl";
	$_SESSION["PATH_MS_MA"]="?".$qstr_ma;
?>
	  <p class="jdltable">Laporan Buku Besar</p>
      <table width="600" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr> 
          <td width="100">Username</td>
          <td width="10">:</td>
          <td width="414"><?php echo strtoupper($username); ?></td>
        </tr>
        <tr> 
          <td>Kode MA</td>
          <td>:</td>
          <td><input name="kode_ma" type="text" id="kode_ma" size="16" maxlength="20" readonly="true" value="<?php echo $kode_ma; ?>" /> 
            <input type="button" name="Button" value="..." onclick="OpenWnd('../master/tree_ma_view.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)" />
          </td>
        </tr>
        <tr> 
          <td>Nama MA</td>
          <td>:</td>
          <td><textarea name="ma" cols="55" rows="2" readonly="true" id="ma"><?php echo $ma; ?></textarea></td>
        </tr>
        <tr> 
          <td>Bulan</td>
          <td width="10">:</td>
          <td><select name="bulan" id="bulan">
              <option value="1|Januari"<?php if ($bulan=="1") echo " selected";?>>Januari</option>
              <option value="2|Pebruari"<?php if ($bulan=="2") echo " selected";?>>Pebruari</option>
              <option value="3|Maret"<?php if ($bulan=="3") echo " selected";?>>Maret</option>
              <option value="4|April"<?php if ($bulan=="4") echo " selected";?>>April</option>
              <option value="5|Mei"<?php if ($bulan=="5") echo " selected";?>>Mei</option>
              <option value="6|Juni"<?php if ($bulan=="6") echo " selected";?>>Juni</option>
              <option value="7|Juli"<?php if ($bulan=="7") echo " selected";?>>Juli</option>
              <option value="8|Agustus"<?php if ($bulan=="8") echo " selected";?>>Agustus</option>
              <option value="9|September"<?php if ($bulan=="9") echo " selected";?>>September</option>
              <option value="10|Oktober"<?php if ($bulan=="10") echo " selected";?>>Oktober</option>
              <option value="11|Nopember"<?php if ($bulan=="11") echo " selected";?>>Nopember</option>
              <option value="12|Desember"<?php if ($bulan=="12") echo " selected";?>>Desember</option>
            </select> </td>
        </tr>
        <tr> 
          <td>Tahun</td>
          <td width="10">:</td>
          <td><select name="ta" id="ta">
              <?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
              <option value="<?php echo $i; ?>"<?php if ($i==$ta) echo " selected";?>><?php echo $i; ?></option>
              <?php }?>
            </select> </td>
        </tr>
      </table>
<?php }elseif ($it=="3"){?>
	  <p class="jdltable">Laporan Neraca Keuangan</p>
      <table width="250" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        <tr> 
          <td width="100">Username</td>
          <td width="10">:</td>
          <td width="414"><?php echo strtoupper($username); ?></td>
        </tr>
        <tr> 
          <td>Tahun</td>
          <td width="10">:</td>
          <td><select name="ta" id="ta">
              <?php for ($i=($th[2]-2);$i<$th[2]+2;$i++){?>
              <option value="<?php echo $i; ?>"<?php if ($i==$ta) echo " selected";?>><?php echo $i; ?></option>
              <?php }?>
            </select> </td>
        </tr>
      </table>
<?php }?>
<p>
        <BUTTON type="button" onClick="<?php if ($it=="2"){?>if (ValidateForm('kode_ma','ind')){window.open(<?php echo $lnk; ?>);}<?php }else{?>window.open(<?php echo $lnk; ?>);<?php }?>"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Cetak Laporan</strong></BUTTON>
</div>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>