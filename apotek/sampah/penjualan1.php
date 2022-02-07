<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$tgltrans1=$_REQUEST["tgltrans"];
$tgltrans=explode("-",$tgltrans1);
$tgltrans=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0];
$nokw=$_REQUEST["nokw"];
	if ($kso_id<>"") {
	$kso=1;
	$kso_id=$_REQUEST["kso_id"];}
	else{
	$kso=0;
	$kso_id=0;}
$nokwPrint=$nokw;
$fdata=$_REQUEST["fdata"];
$no_penjualan=$_REQUEST['nokw'];
$no_kunj=$_REQUEST['no_kunj'];
$NoRM=$_REQUEST['NoRM'];
$nm_pasien=$_REQUEST['nm_pasien'];
$shft=$_REQUEST['shft'];
$subtotal=$_REQUEST['subtotal'];
$embalage=$_REQUEST['embalage'];
$jasa_resep=$_REQUEST['jasa_resep'];
$tot_harga=$_REQUEST['tot_harga'];
$dokter=$_REQUEST['dokter'];
$ruangan=$_REQUEST['ruangan'];
$chk_kso=$_REQUEST['chk_kso'];
//======================Tanggalan==========================
$kepemilikan_id=$_REQUEST["kepemilikan_id"];
if ($kepemilikan_id=="") $kepemilikan_id=$_SESSION["kepemilikan_id"];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="UNIT_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
	//==Cek apakah transaksi ini telah ada pada datanase====
	$sqlCek="select NO_PENJUALAN from a_penjualan where NO_PENJUALAN=$no_penjualan AND UNIT_ID=$idunit";
	//echo $sqlCek;
	$exeCek=mysqli_query($konek,$sqlCek);
	$hitung=mysqli_num_rows($exeCek);
	if ($hitung >0){
	echo "<script>alert('Maaf, No. Transaksi dg nomor $no_penjualan telah ada pada database, silahkan lakukan transaksi lagi')</script>";
	}else{
	//==jika tidak ada pada database, lakukan insert===
		$arfdata=explode("**",$fdata);
		for ($i=0;$i<count($arfdata);$i++)
		{
			$arfvalue=explode("|",$arfdata[$i]);
			$sql="select * from a_penerimaan ap where OBAT_ID=".$arfvalue[0]." and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and QTY_STOK>0 and (ap.STATUS=1 or ap.STATUS=3) order by TANGGAL,ID";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$done="false";
			$jml=$arfvalue[1];
			while (($rows=mysqli_fetch_array($rs))&&($done=="false"))
			{
				$cstok=$rows['QTY_STOK'];
				$cid=$rows['ID'];
				if ($cstok>=$jml)
				{
					$done="true";
					$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,DOKTER,RUANGAN,SHIFT,QTY_JUAL,QTY,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans','$tglact','$no_penjualan','$no_kunj','$NoRM','$dokter','$ruangan',$shft,$jml,$jml,$arfvalue[2],$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien')";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$jml where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
				}else{
					$jml=$jml-$cstok;
					$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,DOKTER,RUANGAN,SHIFT,QTY,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans','$tglact','$no_penjualan','$no_kunj','$NoRM','$dokter',$shft,$cstok,$arfvalue[2],$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien')";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					}
				}
			}
		}
	break;
/* 	case "edit":
		$sql="update a_unit set UNIT_NAME='$unit_name',UNIT_TIPE='$unit_tipe',UNIT_ISAKTIF=$unit_isaktif where UNIT_ID=$unit_id";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		break;
	case "delete":
		$sql="delete from a_unit where UNIT_ID=$unit_id";
		$rs=mysqli_query($konek,$sql);
		//echo $sql;
		break; */
}
//Aksi Save, Edit, Delete Berakhir ====================================
$sql="select *,date_format(TGL,'%d-%m-%Y') as TGL from a_penjualan where UNIT_ID=$idunit and status=0 limit 1";
//echo $sql;
$rs1=mysqli_query($konek,$sql);
if ($rows1=mysqli_fetch_array($rs1)){
	$shft=$rows1["SHIFT"];
	$nokw=$rows1["NO_PENJUALAN"];
	$no_kunj=$rows1["NO_KUNJUNGAN"];
	$tgl=$rows1["TGL"];
}else{
	$sql="select * from a_penjualan where UNIT_ID=$idunit order by NO_PENJUALAN desc limit 1";
	//echo $sql;
	$rs=mysqli_query($konek,$sql);
	$nokw="000001";
	$no_kunj="";
	$shft=1;
	if ($rows=mysqli_fetch_array($rs)){
		$shift=$rows["SHIFT"];
		$nokw=(int)$rows["NO_PENJUALAN"]+1;
		$nokwstr=(string)$nokw;
		if (strlen($nokwstr)<6){
			for ($i=0;$i<(6-strlen($nokwstr));$i++) $nokw="0".$nokw;
		}
	}
}
mysqli_free_result($rs1);
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<!-- Script Pop Up Window -->
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<!-- Script Pop Up Window Berakhir -->
<script language="JavaScript" type="text/JavaScript">
<!--
/*function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
*/
var RowIdx;
var fKeyEnt;
function suggest(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  var i;
  if (jmlRow > 4){
  	i=par.parentNode.parentNode.rowIndex-2;
  }else{
  	i=0;	
  }
  //alert(jmlRow+'-'+i);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblObat').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetObat(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			Request('../transaksi/obatlistjual.php?aKepemilikan='+document.getElementById('kepemilikan_id').value+'&idunit=<?php echo $idunit; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function suggest1(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
  //alert(jmlRow+'-'+i);
	if(keywords==""){
		document.getElementById('divpasien').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblPasien').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetPasien(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			Request('../transaksi/pasienlist.php?aKeyword='+keywords, 'divpasien', '', 'GET' );
			if (document.getElementById('divpasien').style.display=='none') fSetPosisi(document.getElementById('divpasien'),par);
			document.getElementById('divpasien').style.display='block';
		}
	}
}

function fSubmit(){
var cdata='';
var ctemp;
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			ctemp=document.forms[0].obatid[i].value.split('|');
			if ((ctemp[1]*1)<(document.forms[0].txtJml[i].value*1)){
				document.forms[0].txtObat[i].focus();
				alert('Stok Obat Kurang !');
				return false;
			}
			cdata +=ctemp[0]+'|'+document.forms[0].txtJml[i].value+'|'+document.forms[0].txtHarga[i].value+'|'+document.forms[0].txtSubTot[i].value+'|'+document.forms[0].subtotal.value+'|'+document.forms[0].embalage.value+'|'+document.forms[0].jasa_resep.value+'|'+document.forms[0].tot_harga.value+'**';
		}
		if (cdata!='') cdata=cdata.substr(0,cdata.length-2);
/*		for (var i=0;i<document.forms[0].obatid.length-1;i++){
			for (var j=i+1;j<document.forms[0].obatid.length-1;j++){
				
			}
			//alert(document.forms[0].obatid[i].value+'-'+document.forms[0].txtJml[i].value+'-'+document.forms[0].txtHarga[i].value);		
		}
*/
	}else{
		ctemp=document.forms[0].obatid.value.split('|');
		if ((ctemp[1]*1)<(document.forms[0].txtJml.value*1)){
			document.forms[0].txtObat.focus();
			alert('Stok Obat Kurang !');
			return false;
		}
		cdata=ctemp[0]+'|'+document.forms[0].txtJml.value+'|'+document.forms[0].txtHarga.value+'|'+document.forms[0].txtSubTot.value+'|'+document.forms[0].subtotal.value+'|'+document.forms[0].embalage.value+'|'+document.forms[0].jasa_resep.value+'|'+document.forms[0].tot_harga.value;
	}
	//alert(cdata);
	document.forms[0].fdata.value=cdata;
	document.forms[0].submit();
}

function fSetBatalFr(){
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  //alert(jmlRow);
  if (jmlRow > 4){
	  for (var i=jmlRow;i>4;i--){
		tbl.deleteRow(i-1);
	  }
  }
	document.form1.txtObat.focus();
}

function HitungSubTot(par){
//var tbl = document.getElementById('tblJual');
var i=par.parentNode.parentNode.rowIndex;
	//alert(i);
	if (i==3){
		document.form1.txtSubTot.value=(document.form1.txtHarga.value*1)*(document.form1.txtJml.value*1);
	}else{
		document.form1.txtSubTot[i-3].value=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
	}
	HitungTot();
}

function HitungTot(){
	if (document.form1.txtSubTot.length){
		var cStot=0;
		for (var i=0;i<document.form1.txtSubTot.length;i++){
			//alert(document.form1.txtSubTot[i].value);
			cStot +=(document.form1.txtSubTot[i].value*1);
		}
		document.form1.subtotal.value=cStot;
		//alert(cStot);
	}else{
		document.form1.subtotal.value=document.form1.txtSubTot.value;
	}
		document.form1.tot_harga.value=(document.form1.subtotal.value*1)+(document.form1.embalage.value*1)+(document.form1.jasa_resep.value*1);
}

function AddRow(e,par){
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//alert(key);
	if (key==13){
		addRowToTable();
	}else{
		HitungSubTot(par);
	}
}

// Last updated 2006-02-21
function addRowToTable()
{
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById('tblJual');
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
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration-2);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);
  
  // right cell
  var cellRight = row.insertCell(1);
  var el;
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'obatid';
  }else{
  	el = document.createElement('<input name="obatid"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtObat';
	el.setAttribute('OnKeyUp', "suggest(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtObat" onkeyup="suggest(event, this);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 103;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellLeft = row.insertCell(2);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);

  // right cell
  cellRight = row.insertCell(3);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtJml';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
  }else{
  	el = document.createElement('<input name="txtJml" onKeyUp="AddRow(event,this)" />');
  }
  el.type = 'text';
  //el.id = 'txtJml'+(iteration-1);
  el.size = 4;
  el.className = 'txtcenter';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(4);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtHarga';
	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="txtHarga" readonly="true" />');
  }
  el.type = 'text';
  //el.id = 'txtHarga'+(iteration-1);
  el.size = 7;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtSubTot';
  	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="txtSubTot" readonly="true" />');
  }
  el.type = 'text';
  //el.id = 'txtSubTot'+(iteration-1);
  el.size = 10;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('img');
  	el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}');
  }else{
  	el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
  }
  el.src = '../icon/del.gif';
  el.border = "0";
  el.width = "16";
  el.height = "16";
  el.className = 'proses';
  el.align = "absmiddle";
  el.title = "Klik Untuk Menghapus";
  
//  cellRight.setAttribute('class', 'tdisi');
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  document.forms[0].txtObat[iteration-3].focus();

  // select cell
/*  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'selRow';
  sel.id = 'selRow'+iteration;
  sel.options[0] = new Option('text zero', 'value0');
  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
*/
}

function keyPressTest(e, obj){
  var validateChkb = document.getElementById('chkValidateOnKeyPress');
  if (validateChkb.checked) {
    var displayObj = document.getElementById('spanOutput');
    var key;
    if(window.event) {
      key = window.event.keyCode; 
    }
    else if(e.which) {
      key = e.which;
    }
    var objId;
    if (obj != null) {
      objId = obj.id;
    } else {
      objId = this.id;
    }
    displayObj.innerHTML = objId + ' : ' + String.fromCharCode(key);
  }
}
function removeRowFromTable(cRow)
{
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  if (jmlRow > 4){
  	var i=cRow.parentNode.parentNode.rowIndex;
  //if (i>2){
	  tbl.deleteRow(i);
	  var lastRow = tbl.rows.length;
	  for (var i=3;i<lastRow;i++){
		var tds = tbl.rows[i].getElementsByTagName('td');
		tds[0].innerHTML=i-2;
	  }
	  HitungTot();
  }
}

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	if ((cdata[0]*1)==0){
		document.forms[0].obatid.value=cdata[1]+'|'+cdata[5];
		document.forms[0].txtObat.value=cdata[2];
		tds = tbl.rows[3].getElementsByTagName('td');
		document.forms[0].txtHarga.value=cdata[4];
		document.forms[0].txtJml.focus();
	}else{
		var w;
		for (var x=0;x<document.forms[0].obatid.length-1;x++){
			w=document.forms[0].obatid[x].value.split('|');
			//alert(cdata[1]+'-'+w[0]);
			if (cdata[1]==w[0]){
				fKeyEnt=true;
				alert("Obat Tersebut Sudah Ada");
				return false;
			}
		}
		document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1]+'|'+cdata[5];
		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[2];
		tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
		document.forms[0].txtJml[(cdata[0]*1)-1].focus();
	}
	tds[2].innerHTML=cdata[3];

	document.getElementById('divobat').style.display='none';
}

function fSetPasien(par){
var cdata=par.split("*|*");
	document.forms[0].NoRM.value=cdata[0];
	document.forms[0].nm_pasien.value=cdata[1];
	document.forms[0].dokter.focus();
	document.getElementById('divpasien').style.display='none';
}
</script>
<style type="text/css">
<!--
.style1 {font-family: "Courier New", Courier, monospace}
-->
</style>
</head>
<body onLoad="document.form1.NoRM.focus()">
<script>
var arrRange=depRange=[];
</script>
<!-- Script Pop Up Window -->
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<!-- Script Pop Up Window Berakhir -->
<!--script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=500,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script-->

<?php if($act=='save') {?>

<!-- UNTUK DI PRINT OUT -->
<div id="idArea" style="display:none;">
</script>
<style type="text/css">
<!--
.style1 {font-family: "Courier New", Courier, monospace}
-->
</style>
	<?php
	if ($_POST['no_penjualan']<>"") $no_kunj=$_POST['no_penjualan']; else $no_kunj=0;
	$qrySingle="SELECT a_penjualan.*,a_kepemilikan.NAMA,a_user.username from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_user on a_penjualan.USER_ID=a_user.kode_user WHERE a_penjualan.NO_PENJUALAN=$no_penjualan and UNIT_ID=$idunit";
	$exeSingle=mysqli_query($konek,$qrySingle);
	//echo $qrySingle;
	$showSingle=mysqli_fetch_array($exeSingle);
	system("/usr/bin/lpr penjualan.php")
	?>
	<!--link rel="stylesheet" href="../theme/print.css" type="text/css"/-->
    <table width="537" border="0" style="font-family:"Courier New", Courier, monospace">
      <tr>
        <td width="921">
		<table width="530" height="113" border="0" cellpadding="0" cellspacing="0">
         <tr>
		 <td height="45" colspan="2" style="font-size:18px;" class="style1"><b><?=$namaRS;?><br>
            <?=$alamatRS;?>
		   <hr size="1" color="#000000">
		   </b>
		   </td>
          </tr>
          <tr class="style1">
            <td >No. Kwitansi </td>
            <td>: <?php echo $showSingle['NO_PENJUALAN']; ?></td>
          </tr>
          <tr class="style1">
            <td width="234">Tanggal&nbsp; </td>
            <td width="184">: <?php echo date("d/m/Y",strtotime($showSingle['TGL'])); ?></td>
          </tr>
          <tr class="style1">
            <td>No. Kunjungan</td>
            <td>: <?php echo $showSingle['NO_KUNJUNGAN']; ?></td>
          </tr>
          <tr class="style1">
            <td>No Rekam Medis</td>
            <td>: <?php echo $showSingle['NO_PASIEN']; ?></td>
          </tr>
          <tr class="style1">
            <td>Nama Pasien </td>
            <td>: <?php echo $showSingle['NAMA_PASIEN']; ?>&nbsp;</td>
          </tr>
          <tr class="style1">
            <td>Jenis Pasien</td>
            <td>: <?php echo $showSingle['NAMA']; ?></td>
          </tr>
          <tr class="style1">
            <td>Dokter</td>
            <td>: <?php echo $showSingle['DOKTER']; ?></td>
          </tr>
          <tr class="style1">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="style1">
            <td style="font-size:18px">R/</td>
            <td>&nbsp;</td>
          </tr>
        </table>
          <table width="531" border="0" cellpadding="0" cellspacing="0" align="left" class="style1">
            <?php 
				  $sqlPrint="SELECT a_penjualan.*, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL
				  FROM a_penjualan
				  Inner Join a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID
				  Inner Join a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID
				  where a_penjualan.NO_PENJUALAN=$no_penjualan and UNIT_ID=$idunit";
				  $exePrint=mysqli_query($konek,$sqlPrint);
				  $i=1;
				  while($showPrint=mysqli_fetch_array($exePrint)){
				  ?>
            <tr class="style1">
              <td width="29" align="center" ><?php echo $i++ ?></td>
              <td width="255">
			  <?php echo $showPrint['OBAT_NAMA']; ?></td>
              <!--td class="tdisi" align="center" style="border-left:2px solid;border-bottom:2px solid;">
			  <?php echo $showPrint['OBAT_SATUAN_KECIL']; ?></td-->
              <td width="141" align="right" style="font-size:16px">
			  <?php echo $showPrint['QTY']; ?></td>
              <!--td class="tdisi" align="right" style="padding-right:5px; border-left:2px solid;border-bottom:2px solid;">
			  <?php echo $showPrint['HARGA_SATUAN']; ?></td>
              <td class="tdisi" align="right" style="padding-right:5px; border-left:2px solid;border-bottom:2px solid;">
			  <?php echo $showPrint['SUB_TOTAL']; ?></td>
              <td class="tdisi"><?php echo $showPrint['EMBALAGE']; ?></td>
				<td class="tdisi"><?php echo $showPrint['JASA_RESEP']; ?></td>
				<td class="tdisi"><?php echo $showPrint['HARGA_TOTAL']; ?></td-->
            </tr>
            <? } ?>
            <tr class="style1">
              <td colspan="3" align="right" style="padding:5px;">&nbsp;</td>
            </tr>
            <tr class="style1">
              <!--td colspan="4" align="right" class="tdisikiri" style="padding:5px;"><b> Embalage: <?php echo $showSingle['EMBALAGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Jasa Resep: <?php echo $showSingle['JASA_RESEP']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b></td-->
              <td colspan="3" align="right" class="style1" style="padding-right:5px;"><b>Harga Total: Rp. <?php echo number_format($showSingle['HARGA_TOTAL'],0,",","."); ?></b> </td>
            </tr>
            <tr>
              <!--td colspan="4" align="right" class="style1" style="padding:5px;"><b> Embalage: <?php echo $showSingle['EMBALAGE']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Jasa Resep: <?php echo $showSingle['JASA_RESEP']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b></td-->
	<?php
      function kekata($x) {
          $x = abs($x);
          $angka = array("", "satu", "dua", "tiga", "empat", "lima",
          "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
          $temp = "";
          if ($x <12) {
              $temp = " ". $angka[$x];
          } else if ($x <20) {
              $temp = kekata($x - 10). " belas";
          } else if ($x <100) {
              $temp = kekata($x/10)." puluh". kekata($x % 10);
          } else if ($x <200) {
              $temp = " seratus" . kekata($x - 100);
          } else if ($x <1000) {
              $temp = kekata($x/100) . " ratus" . kekata($x % 100);
          } else if ($x <2000) {
              $temp = " seribu" . kekata($x - 1000);
          } else if ($x <1000000) {
              $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
          } else if ($x <1000000000) {
              $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
          } else if ($x <1000000000000) {
              $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
          } else if ($x <1000000000000000) {
              $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
          }      
              return $temp;
      }
      function terbilang($x, $style=4) {
          if($x<0) {
              $hasil = "minus ". trim(kekata($x));
          } else {
              $hasil = trim(kekata($x));
          }      
          switch ($style) {
              case 1:
                  $hasil = strtoupper($hasil);
                  break;
              case 2:
                  $hasil = strtolower($hasil);
                  break;
              case 3:
                  $hasil = ucwords($hasil);
                  break;
              default:
                  $hasil = ucfirst($hasil);
                  break;
          }      
          return $hasil;
      }
	  $bilangan= $showSingle['HARGA_TOTAL'];
      ?>
              <td colspan="3" align="right" style="padding-right:5px;" class="style1">Terbilang: <?php echo terbilang($bilangan,3);?> Rupiah</td>
            </tr>
            <tr>
              <td colspan="3" align="right" style="padding-right:5px;font-size:14px; border-top:1px dashed;">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="right" style="padding-right:5px;" class="style1"><b>Kasir : <?php echo $showSingle['username']; ?></b></td>
            </tr>
            <tr>
              <td colspan="3" align="right" style="padding-right:5px;" class="style1"><i>Bukti pembayaran ini juga berlaku sebagai kwitansi</i></td>
            </tr>
            <tr>
              <td colspan="3" align="right" style="padding-right:5px;" class="style1"></td>
            </tr>
          </table>
 </td>
</tr>
</table>
</div>
    <!-- PRINT OUT BERAKHIR -->
	
<?php }?>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />

<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js" 
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div id="divpasien" align="left" style="position:absolute; z-index:1; left: 200px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="fdata" id="fdata" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	  <table width="99%" border="0">
	  	<tr>
			<td>
  <div id="input" style="display:block" align="center"> 
            <?php include("../koneksi/konekMssql.php");
			if($NoRM=$_REQUEST['NoRM']=="") $NoRM=xxx; else $NoRM=$_REQUEST['NoRM'];
			$qryTMPasien="SELECT * FROM TMPasien where NoRM='$NoRM'";
			//echo $qryTMPasien;
			$rsTMPasien=mssql_query($qryTMPasien);
			$rowsTMPasien=mssql_fetch_array($rsTMPasien);
			$vnama=$rowsTMPasien['Nama'];
			$qstr="par=nm_pasien*no_kunj";
			?>
            <table width="73%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
              <tr> 
                <td width="178">Tanggal&nbsp; </td>
                <td width="235"><input name="tgltrans" type="text" id="tgltrans" size="11" maxlength="10" value="<?php echo $tgl;?>" class="txtcenter" /></td>
				<td width="156">Shift</td>
				<td width="211"><input name="shft" type="text" id="shft" size="2" maxlength="1" value="<?php echo $shft;?>" class="txtcenter" /></td>
              </tr>

              <tr> 
                <td>No Rekam Medis</td>
                <td><input name="NoRM" type="text" id="NoRM" class="txtinput" size="15" value="<?php echo $_REQUEST['NoRM']; ?>">
				<!--a class="navText" href="../transaksi/daftarPasien.php?NoRM=<?php echo $NoRM;?>" onClick="NewWindow(../transaksi/daftarPasien.php,'name','1000','400','yes');return false"-->
                <button type="button" class="txtinput" onClick="NewWindow('../transaksi/daftarPasien.php?NoRM='+NoRM.value+'&<?php echo $qstr;?>','name','1000','400','yes');return false ">
				<img src="../icon/go.png" height="16" width="16" border="0"/></button>
				<!--/a-->
				</td>
              	<td>No. Kwitansi</td>
				<td><input name="nokw" type="text" id="nokw" size="6" maxlength="6" value="<?php echo $nokw;?>" class="txtinput" readonly="true" /></td>
			  </tr>
              <tr>
                <td>Nama Pasien</td>
                <td><input name="nm_pasien" type="text" id="nm_pasien" class="txtinput" size="25" value="<?php echo $vnama;?>"></td> 
                <td>Jenis Pasien</td>
				<td><select name="kepemilikan_id" id="kepemilikan_id" class="txtinput">
                    <?
					  $qry="Select * from a_kepemilikan where aktif=1";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                    <option value="<?=$show['ID'];?>" class="txtinput"<?php if ($kepemilikan_id==$show['ID']) echo " selected";?>> 
                    <?=$show['NAMA'];?>
                    </option>
                    <? }?>
                  </select></td>
              </tr>
			  <tr>
			    <td>No. Kunjungan</td>
			    <td><input name="no_kunj" type="text" id="no_kunj" class="txtinput" size="25" value="<?php echo $no_kunj; ?>" ></td>
			  <td>Ruangan</td>
                <td><select name="ruangan" id="ruangan" class="txtinput" onChange="">
                <option value="0" class="txtinput">Pilih Ruangan</option>
                <?
					  $qry="select * from a_unit where UNIT_TIPE=3 order by UNIT_ID";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                <option value="<?php echo $show['UNIT_ID']; ?>" class="txtinput"<?php if ($ruangan==$show['UNIT_ID']) echo "selected";?>><?php echo $show['UNIT_NAME']; ?></option>
                <? }?>
              </select></td>
			  </tr>
			  <tr>
                <td>Dokter</td>
                <td><input name="dokter" type="text" id="dokter" class="txtinput" size="25" ></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>KSO / Mitra</td>
                <td colspan="3"><select name="kso_id" id="kso_id" class="txtinput" onChange="fSelChange(this);">
                <option value="0" class="txtinput">Pilih KSO</option>
                <?
					  $qry="select * from a_mitra";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                <option value="<?php echo $show['IDMITRA']; ?>" lang="<?php echo $show['KEPEMILIKAN_ID']; ?>" class="txtinput"<?php if ($kso_id==$show['IDMITRA']) echo "selected";?>><?php echo $show['NAMA']; ?></option>
                <? }?>
              </select></td>
              </tr>
            </table>
  </div>
  <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">

  	<tr>
		<td colspan="7" align="center" class="jdltable"><hr></td>
	</tr>
  	<tr>
		<td colspan="6" align="center" class="jdltable">DAFTAR PENJUALAN</td>
		<td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
	</tr>
      <tr class="headtable">
        <td width="25" class="tblheaderkiri">No</td>
		<td class="tblheader">Nama Obat</td>
		<td width="75" class="tblheader">Satuan</td>
		<td width="30" class="tblheader">Jml</td>
		<td width="50" class="tblheader">Hrg<br>Satuan</td>
		<td width="70" class="tblheader">Subtotal</td>
        <td class="tblheader" width="30">Proses</td>
      </tr>
	  <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
		<td class="tdisikiri" width="25">1</td>
		<td class="tdisi" align="left"><input name="obatid" type="hidden" value="">
		  <input type="text" name="txtObat" id="txtObat" class="txtinput" size="103" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
		      <td class="tdisi" width="80">-</td>
		<td class="tdisi" width="30"><input type="text" name="txtJml" id="txtJml" class="txtcenter" size="4" onKeyUp="AddRow(event,this)" /></td>
		<td class="tdisi" width="50"><input type="text" name="txtHarga" class="txtright" readonly="true" size="7" /></td>
		      <td class="tdisi" width="70"><input type="text" name="txtSubTot" class="txtright" readonly="true" size="10" /></td>
        <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
	  </tr>
  </table>
  
    </table>
    <table width="50%" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr> 
        <td>SUBTOTAL HARGA &nbsp;</td>
        <td><input name="subtotal" type="text" id="subtotal" size="12" value="" class="txtright" readonly="true" /></td>
        <td rowspan="4" width="50">&nbsp;</td>
        <td rowspan="4"><p>

			<BUTTON type="button" onClick="if (ValidateForm('tgltrans,shft,no_kunj,nokw,NoRM,txtObat,txtJml,dokter,ruangan','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
            &nbsp;<br>
        <BUTTON type="reset" onClick="fSetBatalFr();location='?f=../transaksi/penjualan.php';"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Reset&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>&nbsp;<br>
		 <a class="navText" href="../apotik/kwi.php?no_penjualan=<?php echo $nokwPrint;?>&sunit=<?php echo $idunit; ?>" onClick="NewWindow(this.href,'name','500','500','yes');return false">
		<BUTTON  type="button" <?php  if($act<>'save') echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Penjualan</BUTTON>
			</a>
          </p></td>
      </tr>
      <tr> 
        <td>EMBALAGE</td>
        <td><input name="embalage" type="text" id="embalage" size="12" value="0" class="txtright" onKeyUp="HitungTot()" /></td>
      </tr>
      <tr> 
        <td>JASA RESEP</td>
        <td><input name="jasa_resep" type="text" id="jasa_resep" size="12" value="0" class="txtright" onKeyUp="HitungTot()" /></td>
      </tr>
      <tr> 
        <td>TOTAL HARGA</td>
        <td><input name="tot_harga" type="text" id="tot_harga" size="12" value="0" class="txtright" readonly="true" /></td>
      </tr>
    </table>
		</td>
	</tr>
</table>
</form>
</div>
</body>
<script>
function fSelChange(obj){
	//alert(obj.options[obj.options.selectedIndex].lang);
	if (document.forms[0].obatid.length){
		//fSetValue(window,'kepemilikan_id*-*'+obj.options[obj.options.selectedIndex].lang);
		window.location="?f=../transaksi/penjualan.php&kepemilikan_id="+obj.options[obj.options.selectedIndex].lang+"&kso_id="+obj.value+'&chk_kso=true';
	}else{
		fSetValue(window,'kepemilikan_id*-*'+obj.options[obj.options.selectedIndex].lang);
	}
}
</script>
</html>
<?php 
mysqli_close($konek);
?>