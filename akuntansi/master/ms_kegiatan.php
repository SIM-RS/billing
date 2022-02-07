<?php 
include("../koneksi/konek.php");
$th=gmdate('Y',mktime(date('H')+7));

$idkg=$_REQUEST['idkg'];
$ta=$_REQUEST['ta'];
if ($ta=="") $ta=$th;
$kode_kg=trim($_REQUEST['kode_kg']);
$kg=str_replace("\'","''",trim($_REQUEST['kg']));
$kg=str_replace('\"','"',$kg);
$kg=str_replace(chr(92).chr(92),chr(92),$kg);
$pagu=$_REQUEST['pagu'];if ($pagu=="") $pagu="0";
$archkjd=$_REQUEST['archkjd'];//echo $archkjd;
$archkjd=explode("-",$archkjd);
$kode_kg2=trim($_REQUEST['kode_kg2']);
if ($kode_kg2==""){
	$parent=0;
	$parent_lvl=0;
}else{
	$kode_kg=$kode_kg2.$kode_kg;
	$parent=$_REQUEST['parent'];
	if ($parent=="") $parent=0;
	$parent_lvl=$_REQUEST['parent_lvl'];
	if ($parent_lvl=="") $parent_lvl=0;
}

$lvl=$parent_lvl+1;
$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "save":
		$sql="select * from KEGIATAN where KG_KODE='$kode_kg' and KG_TAHUN=$ta";
		//echo $sql;
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Kegiatan Sudah Ada');</script>";
		}else{
			$sql="insert into KEGIATAN(KG_KODE,KG_TAHUN,KG_TAHUN1,KG_KET,KG_LEVEL,KG_PARENT,KG_PARENT_KODE,KG_PAGU,KG_TRW1,KG_TRW2,KG_TRW3,KG_TRW4) values('$kode_kg',$ta,$ta,'$kg',$lvl,$parent,'$kode_kg2',$pagu,$archkjd[0],$archkjd[1],$archkjd[2],$archkjd[3])";
			//echo $sql;
			$rs=mysql_query($sql);
/*			if ($parent>0){
				$sql="update KEGIATAN set KG_ISLAST=0 where KG_ID=$parent";
				//echo $sql;
				$rs=mysql_query($sql);
			}
*/		}
		mysql_free_result($rs1);
		break;
	case "edit":
		$sql="update KEGIATAN set KG_KODE='$kode_kg',KG_KET='$kg',KG_LEVEL=$lvl,KG_PARENT=$parent,KG_PARENT_KODE='$kode_kg2',KG_PAGU=$pagu,KG_TRW1=$archkjd[0],KG_TRW2=$archkjd[1],KG_TRW3=$archkjd[2],KG_TRW4=$archkjd[3] where KG_ID=$idkg";
		$rs=mysql_query($sql);
		break;
	case "delete":
		$sql="delete from KEGIATAN where KG_ID=$idkg";
		$rs=mysql_query($sql);
		break;
}
?>
<html>
<head>
<title>Data Master Kegiatan</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
</head>
<script>
function fSetArchkjd(){
var s="";
	for (var i=0;i<4;i++){
		//alert(document.form1.chkjd[i].checked);
		if (document.form1.chkjd[i].checked){
			s=s+"1-";
		}else{
			s=s+"0-";
		}
	}
	s=s.substr(0,s.length-1);
	document.form1.archkjd.value=s;
}
</script>
<body>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="idkg" id="idkg" type="hidden" value="">
  <input name="parent_lvl" id="parent_lvl" type="hidden" value="<?php echo $parent_lvl; ?>">
  <input name="parent" id="parent" type="hidden" value="<?php echo $parent; ?>">
  <input name="kginduk" id="kginduk" type="hidden" value="<?php echo $kginduk; ?>">
  <input name="archkjd" id="archkjd" type="hidden" value="">
  <div id="input" style="display:none">
      <p class="jdltable">Data Kegiatan</p>
      <table width="70%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td width="33%">Kode Kegiatan</td>
          <td width="2%">:</td>
          <td width="71%"><input name="kode_kg2" type="text" id="kode_kg2" size="10" maxlength="15" style="text-align:center" value="<?php echo $kode_kg2; ?>" readonly="true"> 
            <input type="button" name="Button222" value="..." title="Pilih Kode Rencana Strategis" onClick="OpenWnd('../master/ms_kegiatan_view.php?idkg=parent&kodekg=kode_kg2&kg=kginduk&lvl=parent_lvl&ta='+ta.value,800,500,'mskg',true)">
			<input name="kode_kg" type="text" id="kode_kg" size="4" maxlength="6" style="text-align:center">
		  </td>
        </tr>
        <tr> 
          <td>Nama Kegiatan</td>
          <td>:</td>
          <td><textarea name="kg" cols="50" id="kg"></textarea></td>
        </tr>
        <tr> 
          <td>Nilai Pagu (Rp)</td>
          <td>:</td>
          <td><input name="pagu" type="text" id="pagu" size="12" maxlength="12" class="txtright"> 
          </td>
        </tr>
        <tr> 
          <td>JADWAL WAKTU (Triw) </td>
          <td>:</td>
          <td><input type="checkbox" name="chkjd" id="chkjd" value="checkbox">
            I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="chkjd" id="chkjd" value="checkbox">
            II&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="chkjd" id="chkjd" value="checkbox">
            III&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="chkjd" id="chkjd" value="checkbox">
            IV</td>
        </tr>
        <tr> 
          <td colspan="3" height="20">&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>
  			<p><BUTTON type="button" onClick="if (ValidateForm('kode_kg,kg','ind')){fSetArchkjd();document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Simpan</strong></BUTTON>
				&nbsp;&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('list').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Batal</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
          </td>
        </tr>
      </table>
  </div>
  <div id="list" style="display:block">
    <p><span class="jdltable">Daftar Kegiatan</span>
	<table width="100%" border="0" cellspacing="0" cellpadding="4">
		<tr>
		  <td colspan="3"></td>
	    </tr>
		<tr>
			<td width="250"></td>
			<td >
				<span class="bodyText">data tahun</span>		      <select name="ta" id="ta" onChange="location='?f=../master/ms_kegiatan.php&ta='+this.value">
					<?php for ($i=$th-2;$i<$th+2;$i++){?>
					<option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
					<?php }?>
				  </select>			</td>
			<td width="250" align="right"><BUTTON type="button" onClick="document.getElementById('input').style.display='block';document.getElementById('list').style.display='none';"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON></td>
		</tr>
	</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr class="headtable"> 
        <td width="24" rowspan="2" class="tblheaderkiri">No</td>
        <td width="150" rowspan="2" class="tblheader">Sasaran<br>(Rentra) </td>
        <td width="150" rowspan="2" class="tblheader">Kebijakan (Renstra) </td>
        <td width="150" rowspan="2" class="tblheader">Program Kerja (Renstra) </td>
        <td width="85" rowspan="2" class="tblheader">kode</td>
        <td width="190" rowspan="2" class="tblheader">Kegiatan<br>(renstra)</td>
        <td width="120" rowspan="2" class="tblheader">Sub Kegiatan<br>(Unit Kerja)</td>
        <td width="150" rowspan="2" class="tblheader">Nilai Pagu</td>
        <td width="80" height="58" colspan="4" class="tblheader">JADWAL WAKTU<br>(Triwulan)</td>
      </tr>
      <tr class="headtable">
        <td width="20" class="tblheader">I</td>
        <td width="20" class="tblheader">II</td>
        <td width="20" class="tblheader">III</td>
        <td width="20" class="tblheader">IV</td>
      </tr>
	  <?php 
	  $sql="select * from KEGIATAN where KG_TAHUN='$ta' order by KG_KODE";
	  $rs=mysql_query($sql);
	  $i=0;$j=0;
	  $arfvalue="";
	  $arkg=array();
	  for ($k=1;$k<6;$k++) $arkg[$k]="&nbsp;";
	  while ($rows=mysql_fetch_array($rs)){
	  	if ($rows['KG_LEVEL']==4){
			$pkode=trim($rows['KG_PARENT_KODE']);
			$mkode=trim($rows['KG_KODE']);
		 	if ($pkode!="") $mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
			$arfvalue="act*-*edit*|*kode_kg2*-*".$pkode."*|*idkg*-*".$rows['KG_ID']."*|*kode_kg*-*".$mkode."*|*kg*-*".$rows['KG_KET']."*|*parent_lvl*-*".($rows['KG_LEVEL']-1)."*|*parent*-*".$rows['KG_PARENT']."*|*pagu*-*".$rows['KG_PAGU'];
			$arfhapus="act*-*delete*|*idkg*-*".$rows['KG_ID'];
			$strpro="<br><br>[<IMG SRC='../icon/edit.gif' border='0' width='16' height='16' ALIGN='absmiddle' class='proses' title='Klik Untuk Mengubah' onClick=\"document.getElementById('input').style.display='block';document.getElementById('list').style.display='none';fSetValue(window,'$arfvalue');\"> | <IMG SRC='../icon/del.gif' border='0' width='16' height='16' ALIGN='absmiddle' class='proses' title='Klik Untuk Menghapus' onClick=\"if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'$arfhapus');document.form1.submit();}\">]";
			$arkg[4]=$rows['KG_KET'].$strpro;
			
			$sql="select * from KEGIATAN where KG_PARENT=".$rows['KG_ID'];
			$rs1=mysql_query($sql);
			if (mysql_num_rows($rs1)<=0){
				$i++;
				//$arkg[5]="&nbsp;";
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[1]; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[2]; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[3]; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['KG_KODE']; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[4]; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[5]; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['KG_PAGU'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW1']==1) echo "V"; else echo "-";?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW2']==1) echo "V"; else echo "-";?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW3']==1) echo "V"; else echo "-";?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW4']==1) echo "V"; else echo "-";?></td>
      </tr>
	  <?php 
				$j=0;
				for ($k=1;$k<5;$k++) $arkg[$k]="&nbsp;";
	  		}
			mysql_free_result($rs1);
		}elseif ($rows['KG_LEVEL']==5){
			$i++;
			$pkode=trim($rows['KG_PARENT_KODE']);
			$mkode=trim($rows['KG_KODE']);
		 	if ($pkode!="") $mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
			$arfvalue="act*-*edit*|*kode_kg2*-*".$pkode."*|*idkg*-*".$rows['KG_ID']."*|*kode_kg*-*".$mkode."*|*kg*-*".$rows['KG_KET']."*|*parent_lvl*-*".($rows['KG_LEVEL']-1)."*|*parent*-*".$rows['KG_PARENT']."*|*pagu*-*".$rows['KG_PAGU'];
			$arfhapus="act*-*delete*|*idkg*-*".$rows['KG_ID'];
			$strpro="<br><br>[<IMG SRC='../icon/edit.gif' border='0' width='16' height='16' ALIGN='absmiddle' class='proses' title='Klik Untuk Mengubah' onClick=\"document.getElementById('input').style.display='block';document.getElementById('list').style.display='none';fSetValue(window,'$arfvalue');\"> | <IMG SRC='../icon/del.gif' border='0' width='16' height='16' ALIGN='absmiddle' class='proses' title='Klik Untuk Menghapus' onClick=\"if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'$arfhapus');document.form1.submit();}\">]";
			$arkg[5]=$rows['KG_KET'].$strpro;
		?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[1]; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[2]; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[3]; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['KG_KODE']; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[4]; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[5]; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['KG_PAGU'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW1']==1) echo "V"; else echo "-";?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW2']==1) echo "V"; else echo "-";?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW3']==1) echo "V"; else echo "-";?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW4']==1) echo "V"; else echo "-";?></td>
      </tr>		
		<?php
			$j=0;
			for ($k=1;$k<6;$k++) $arkg[$k]="&nbsp;";
		}else{
			$j++;
			$arkg[$j]=$rows['KG_KET'];
			$sql="select * from KEGIATAN where KG_PARENT=".$rows['KG_ID'];
			$rs1=mysql_query($sql);
			if (mysql_num_rows($rs1)<=0){
				$i++;
		?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri"><?php echo $i; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[1]; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[2]; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[3]; ?></td>
        <td align="center" class="tdisi"><?php echo $rows['KG_KODE']; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[4]; ?></td>
        <td align="left" class="tdisi"><?php echo $arkg[5]; ?></td>
        <td align="right" class="tdisi"><?php echo number_format($rows['KG_PAGU'],0,",","."); ?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW1']==1) echo "V"; else echo "-";?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW2']==1) echo "V"; else echo "-";?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW3']==1) echo "V"; else echo "-";?></td>
        <td align="center" class="tdisi"><?php if ($rows['KG_TRW4']==1) echo "V"; else echo "-";?></td>
      </tr>
		<?php
				$j=0;
				for ($k=1;$k<6;$k++) $arkg[$k]="&nbsp;";
			}
			mysql_free_result($rs1);
		}
	  }
	  mysql_free_result($rs);
	  ?>
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