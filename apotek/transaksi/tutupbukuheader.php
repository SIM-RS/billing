<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$th);


$cunit=$_REQUEST["cunit"];
$ta=$_REQUEST['ta'];
$bulan=$_REQUEST["bulan"];
$key=$_REQUEST['key'];
$act=$_REQUEST['act'];
convert_var($cunit,$ta,$bulan,$key,$act);

if ($ta=="") $ta=$th[2];
if ($bulan==""){
	$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}else{
	$bulan=explode("|",$bulan);
}

$enable = 0;
if($key=='dsjaya'){
	$enable = 1;
}


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
$("document").ready(function()
	{
		//kode dbwah sni
		var hari=document.getElementById('hariIni').value;
		if(hari==01){
		var idunit=document.getElementById('cunit').value;
		var enCM='<?php echo $enableCM; ?>';
		var admin = '<?php echo $enable; ?>';
		if(admin == 1){
			enCM = 1;
		}
			if (enCM=='1'){
				document.getElementById('proses').style.display='block';
				document.getElementById('input').style.display='none';
				//alert("../transaksi/tutupbuku_utils.php?bulan="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value+"&cunit="+document.getElementById('cunit').value);
				XMLCloseMonth("../transaksi/tutupbuku_utils.php?bulan="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value+"&cunit="+document.getElementById('cunit').value);
			}else{
				alert("Proses Close Month Tidak Diperlukan Lagi Karena Sudah Dilakukkan Secara Otomatis Oleh Server !");
			}
		}

	});
function ProsesCloseMonth(){
var idunit=document.getElementById('cunit').value;
var enCM='<?php echo $enableCM; ?>';
var admin = '<?php echo $enable; ?>';
if(admin == 1){
	enCM = 1;
}
	if (enCM=='1'){
		document.getElementById('proses').style.display='block';
		document.getElementById('input').style.display='none';
		//alert("../transaksi/tutupbuku_utils.php?bulan="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value+"&cunit="+document.getElementById('cunit').value);
		XMLCloseMonth("../transaksi/tutupbuku_utils.php?bulan="+document.getElementById('bulan').value+"&ta="+document.getElementById('ta').value+"&cunit="+document.getElementById('cunit').value);
	}else{
		alert("Proses Close Month Tidak Diperlukan Lagi Karena Sudah Dilakukkan Secara Otomatis Oleh Server !");
	}
}
</script>
<body>
<div align="center" style="display:none">
<!-- <input type='text' id='hariIni' value='<?php echo gmdate('d',mktime(date('H')+7)); ?>'>
	<input type='text' id='bulanIni' value='<?php echo gmdate('m',mktime(date('H')+7))-1; ?>'>
	<input type='text' id='tahunIni' value='<?php echo gmdate('Y',mktime(date('H')+7)); ?>'> -->
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>