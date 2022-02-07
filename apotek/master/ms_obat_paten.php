<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$par=$_REQUEST['par'];
$par=explode("*",$par);
$id_paten=$_REQUEST['id_paten'];
if ($id_paten=="") $id_paten="0";
?>
<html>
<title>Setup Obat Paten dr Obat Generik</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<style>
BODY, TD {font-family:Verdana; font-size:7pt}
.NormalBG 
{
	background-color : #FFFFFF;
}

.AlternateBG { 
	background-color : #EDF1FE;
}

</style>
<script>
function addRowToTable(TableID,ChkName,NodeValue)
{
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById(TableID);
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  	//row.id = 'row'+(iteration-1);
  	row.className = 'itemtable';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableMOver';};
	row.onmouseout = function(){this.className='itemtable';};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  
  var cellItem = row.insertCell(0);
  var cellNode;
  var CellValue=NodeValue.split("*|*");
  if(!isIE){
  	cellNode = document.createElement('input');
  	cellNode.name = ChkName;
  }else{
  	cellNode = document.createElement('<input name="'+ChkName+'"/>');
  }
  cellNode.type = 'checkbox';
  cellNode.value = CellValue[0];
  cellItem.className = 'tdisikiri';
  cellItem.appendChild(cellNode);
  
  cellItem = row.insertCell(1);
  cellNode = document.createTextNode(CellValue[1]);
  cellItem.width = "60";
  cellItem.className = 'tdisi';
  cellItem.appendChild(cellNode);
  
  cellItem = row.insertCell(2);
  cellNode = document.createTextNode(CellValue[2]);
  cellItem.width = "177";
  cellItem.align = "left";
  cellItem.className = 'tdisi';
  cellItem.appendChild(cellNode);
  
  cellItem = row.insertCell(3);
  cellNode = document.createTextNode(CellValue[3]);
  cellItem.width = "60";
  cellItem.className = 'tdisi';
  cellItem.appendChild(cellNode);
}

function AddObatPaten(TableID,TableID2,ChkName,ChkName2,nChk){
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById(TableID);
  var lastRow = tbl.rows.length;
  var tds;
  var rowidx='';
	for (var it=0;it<lastRow;it++){
		if (lastRow>1){
			if (ChkName[it].checked==true){
				tds = tbl.rows[it].getElementsByTagName('td');
				//alert(document.forms[0].chkNoSel[it].value+'|'+tds[1].innerHTML+'|'+tds[2].innerHTML+'|'+tds[3].innerHTML);
				addRowToTable(TableID2,nChk,ChkName[it].value+'*|*'+tds[1].innerHTML+'*|*'+tds[2].innerHTML+'*|*'+tds[3].innerHTML);
				rowidx=rowidx+it+"|";
			}
		}else{
			if (ChkName.checked==true){
				tds = tbl.rows[it].getElementsByTagName('td');
				//alert(document.forms[0].chkNoSel.value+'|'+tds[1].innerHTML+'|'+tds[2].innerHTML+'|'+tds[3].innerHTML);
				addRowToTable(TableID2,nChk,ChkName.value+'*|*'+tds[1].innerHTML+'*|*'+tds[2].innerHTML+'*|*'+tds[3].innerHTML);
				rowidx=rowidx+it+"|";
			}
		}
	}
	
	if (rowidx!=""){
		//alert(rowidx);
		rowidx=rowidx.substr(0,rowidx.length-1);
		var arRowIdx=rowidx.split("|");
		for (var it=0;it<arRowIdx.length;it++){
			//alert(it);
			tbl.deleteRow(arRowIdx[it]-it);
		}
	}
}

function fSubmit(){
var tbl = document.getElementById('tblObatSel');
var lastRow = tbl.rows.length;
var tdata='';
var tkode='';
var tmp;
	//alert(lastRow);
	if (lastRow>0){
		if (document.forms[0].chkSel.length){
			for (var it=0;it<document.forms[0].chkSel.length;it++){
				//alert(document.forms[0].chkSel[it].value);
				tmp=document.forms[0].chkSel[it].value.split("|");
				tdata +=tmp[0]+",";
				tkode +=tmp[1]+",";
			}
			
			tdata=tdata.substr(0,tdata.length-1);
			tkode=tkode.substr(0,tkode.length-1);
		}else{
			tmp=document.forms[0].chkSel.value.split("|");
			tdata=tmp[0];
			tkode=tmp[1];
		}
		tmp='<?php echo $par[0];?>*-*'+tdata+"*|*"+'<?php echo $par[1]; ?>'+"*-*"+tkode;
		//alert(tmp);
		fSetValue(window.opener,tmp);
		window.close();
	}else{
		tmp='<?php echo $par[0];?>*-*0'+"*|*"+'<?php echo $par[1]; ?>'+"*-*";
		//alert(tmp);
		fSetValue(window.opener,tmp);
		window.close();
	}
}
</script>
<body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();">
<div align="center">
<form name="form1" method="post" action="">
<!--table border=1 cellspacing=0 width="98%">
<tr>
  <td class=GreenBG align=center><font size=1><b>
.: Data Obat:.
</b></font></td>
</tr>
<tr bgcolor="whitesmoke"><td nowrap>
<?php	
/*  $j=0;
  $strSQL = "SELECT OBAT_ID,OBAT_KODE,OBAT_NAMA,OBAT_SATUAN_KECIL FROM a_obat WHERE OBAT_KATEGORI<>1 AND OBAT_KATEGORI<>4 AND OBAT_ISAKTIF=1 ORDER BY OBAT_NAMA";
  $rs = mysqli_query($konek,$strSQL);
  while ($rows=mysqli_fetch_array($rs)){
      $j++;
      if ($j % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
	  $tdata=$rows["OBAT_ID"]."|".$rows["OBAT_KODE"];
      echo "<tr class=$rowStyle onMouseOver=\"this.className='MoverBG'\" onMouseOut=\"this.className='$rowStyle'\"><td>";
	  echo "<input type='checkbox' name='idobat' id='idobat' value=\"$tdata\">&nbsp;&nbsp;";
	  echo $rows["OBAT_KODE"]." - ".$rows["OBAT_NAMA"];
	  echo "</td></tr>";
	}
	mysqli_free_result($rs);*/
?>
</td>
</tr>
</table-->
<table width="700" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
    </tr>
  <tr>
    <td align="center"><strong>List Seluruh Obat Non Generik</strong></td>
    <td>&nbsp;</td>
    <td align="center"><strong>List Obat Paten Yang Dipilih</strong></td>
  </tr>
  <tr>
    <td align="center">
    <div align="left" style="height: 230px; width: 300px; overflow: scroll; border:1px solid; display:block; background-color: #CCCCCC; layer-background-color: #CCCCCC;">
    <table id="tblObatNoSel" border="0" cellpadding="1" cellspacing="0">
    <?php 
	$i=0;
  $strSQL = "SELECT OBAT_ID,OBAT_KODE,OBAT_NAMA,OBAT_SATUAN_KECIL FROM $dbapotek.a_obat WHERE OBAT_KATEGORI<>1 AND OBAT_KATEGORI<>4 AND OBAT_ISAKTIF=1 AND OBAT_ID NOT IN ($id_paten) ORDER BY OBAT_NAMA";
  //echo $strSQL."<BR>";
  $rs = mysqli_query($konek,$strSQL);
  while ($rows=mysqli_fetch_array($rs)){
      $i++;
      if ($i % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
	  $tdata=$rows["OBAT_ID"]."|".$rows["OBAT_KODE"];
	?>
      <!--tr lang="<?php //echo $tdata; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="if (document.forms[0].chkNoSel.length){if (document.forms[0].chkNoSel[<?php //echo $i-1; ?>].checked==false) document.forms[0].chkNoSel[<?php //echo $i-1; ?>].checked=true; else document.forms[0].chkNoSel[<?php //echo $i-1; ?>].checked=false;}else{if (document.forms[0].chkNoSel.checked==false) document.forms[0].chkNoSel.checked=true; else document.forms[0].chkNoSel.checked=false;};"-->
      <tr lang="<?php echo $tdata; ?>" class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri" width="10" align="center"><input type="checkbox" name="chkNoSel" id="chkNoSel<?php echo $i-1; ?>" value="<?php echo $tdata; ?>" /></td>
        <td class="tdisi" width="80" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
		<td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
		<td class="tdisi" width="80" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
      </tr>
      <?php 
	}
	mysqli_free_result($rs);
	  ?>
	</table>
    </div>
    </td>
    <td>
        <input type="button" name="button" id="button" value=" > " onClick="AddObatPaten('tblObatNoSel','tblObatSel',document.forms[0].chkNoSel,document.forms[0].chkSel,'chkSel')"><br>
        <input type="button" name="button" id="button" value=" < " onClick="AddObatPaten('tblObatSel','tblObatNoSel',document.forms[0].chkSel,document.forms[0].chkNoSel,'chkNoSel')">    </td>
    <td align="center">
    <div align="left" style="height: 230px; width: 300px; overflow: scroll; border:1px solid; display:block; background-color: #CCCCCC; layer-background-color: #CCCCCC;">
    <table id="tblObatSel" border="0" cellpadding="1" cellspacing="0">
    <?php 
	$i=0;
  $strSQL = "SELECT OBAT_ID,OBAT_KODE,OBAT_NAMA,OBAT_SATUAN_KECIL FROM $dbapotek.a_obat WHERE OBAT_ID IN ($id_paten) ORDER BY OBAT_NAMA";
  $rs = mysqli_query($konek,$strSQL);
  while ($rows=mysqli_fetch_array($rs)){
      $i++;
      if ($i % 2) $rowStyle = "NormalBG";  else $rowStyle = "AlternateBG";
	  $tdata=$rows["OBAT_ID"]."|".$rows["OBAT_KODE"];
	?>
      <!--tr lang="<?php //echo $tdata; ?>" class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="if (document.forms[0].chkSel.length){if (document.forms[0].chkSel[<?php //echo $i-1; ?>].checked==false) document.forms[0].chkSel[<?php //echo $i-1; ?>].checked=true; else document.forms[0].chkSel[<?php //echo $i-1; ?>].checked=false;}else{if (document.forms[0].chkSel.checked==false) document.forms[0].chkSel.checked=true; else document.forms[0].chkSel.checked=false;};"-->
      <tr lang="<?php echo $tdata; ?>" class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri" width="10"><input type="checkbox" name="chkSel" value="<?php echo $tdata; ?>" /></td>
        <td class="tdisi" width="60" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
		<td class="tdisi" width="177" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
		<td class="tdisi" width="60" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
      </tr>
      <?php 
	}
	mysqli_free_result($rs);
	  ?>
	</table>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="3" align="center"><br>
    <input type="button" name="button2" id="button2" value="Simpan" onClick="fSubmit();">
    <input type="button" name="button2" id="button2" value="   Batal   " onClick="window.close();">
    </td>
    </tr>
</table>
<p>&nbsp;</p>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>