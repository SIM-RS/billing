<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$th);
$cunit=$_REQUEST["cunit"];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST["bulan"];
if ($bulan==""){
	$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}else{
	$bulan=explode("|",$bulan);
}

$act=$_REQUEST['act'];
//echo $act;
/*switch ($act){
	case "save":
		$sql="";
		//echo $sql."<br>";
		//$rs1=mysqli_query($konek,$sql);
		break;
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transaksi Close Month</title>
<link href="../theme/apotik.css" rel="stylesheet" type="text/css" />
</head>
<script>
function newXMLRequest() {
	this.xmlhttp = false;
	
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		this.xmlhttp = new XMLHttpRequest();
		if (this.xmlhttp.overrideMimeType) {
			this.xmlhttp.overrideMimeType('text/html');
		}
	} 
	else if (window.ActiveXObject) { // IE
		var MsXML = new Array('Msxml2.XMLHTTP.5.0','Msxml2.XMLHTTP.4.0','Msxml2.XMLHTTP.3.0','Msxml2.XMLHTTP','Microsoft.XMLHTTP');	
		for (var i = 0; i < MsXML.length; i++) {
			try {
				this.xmlhttp = new ActiveXObject(MsXML[i]);
			} catch (e) {}
		}
	}	
}

function XMLCloseMonth(vUrl){
var XMLProc=new newXMLRequest();

  if (XMLProc.xmlhttp) {
    XMLProc.xmlhttp.open("GET" , vUrl, true);
	XMLProc.xmlhttp.onreadystatechange = function() {
		if (typeof(XMLProc) != 'undefined' && XMLProc.xmlhttp.readyState == 4) {
			if (XMLProc.xmlhttp.status == 200 || XMLProc.xmlhttp.status == 304) {
				//GetId(vTarget).innerHTML = XMLProc.xmlhttp.responseText;
				document.getElementById("wait").innerHTML="<span class=\"jdltable\">Proses Close Month Stok Obat : Selesai</span>";
				//document.getElementById("wait").innerHTML="<span class=\"jdltable\">Proses Close Month Stok Obat : Selesai</span><br/>"+XMLProc.xmlhttp.responseText;
			}else{
				XMLProc.xmlhttp.abort();
			}
		}
	}
	
	if (window.XMLHttpRequest) {
	  XMLProc.xmlhttp.send(null);
	} else if (window.ActiveXObject) {
	  XMLProc.xmlhttp.send();
	}
  }
  return false;
}

function ProsesCloseMonth(){
var idunit=document.getElementById('cunit').value;
	//alert(idunit);
	document.getElementById('proses').style.display='block';
	document.getElementById('input').style.display='none';
	//alert("../transaksi/tutupbuku_utils.php?bulan="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value+"&cunit="+document.getElementById('cunit').value);
	XMLCloseMonth("../transaksi/tutupbuku_utils.php?bulan="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value+"&cunit="+document.getElementById('cunit').value);
}
</script>
<body>
<div align="center">
<form name="form1" method="post">
  <input name="act" id="act" type="hidden" value="save">
<div id="proses" style="display:none">
	<br>
	  <div id="wait"><span class="jdltable">Proses Close Month Stok Obat :&nbsp;<img src="../icon/wait.gif" />&nbsp;Tunggu...</span></div>
</div>
<div id="input" style="display:block">
	  <p class="jdltable">Proses Close Month Stok Obat</p>
      <table width="300" border="0" cellspacing="0" cellpadding="0" class="txtinput">
        
        <tr>
          <td>Unit</td>
          <td>:</td>
          <td><select name="cunit" id="cunit" class="txtinput" <?php if ($idunit!=1) echo 'disabled="disabled"';?>>
          	<?php 
			$sql="SELECT * FROM a_unit WHERE UNIT_TIPE<>3 AND UNIT_TIPE<>4 ORDER BY UNIT_ID";
			$rs=mysqli_query($konek,$sql);
			while ($rows=mysqli_fetch_array($rs)){
			?>
              <option value="<?php echo $rows['UNIT_ID'];?>"<?php if ($idunit==$rows['UNIT_ID']) echo " selected";?>><?php echo $rows['UNIT_NAME']; ?></option>
            <?php 
			}
			?>
            </select>
          </td>
        </tr>
        <tr> 
          <td width="100">Bulan</td>
          <td width="10">:</td>
          <td width="414"><select name="bulan" id="bulan">
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
<p>
        <BUTTON type="button" onClick="ProsesCloseMonth();"><IMG SRC="../icon/ok.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Proses</strong></BUTTON>
</div>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>