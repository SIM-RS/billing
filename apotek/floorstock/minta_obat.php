<?php 
include("../sesi.php"); 
// Koneksi =================================
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tgl_ctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$bulan=(int)$th[1];
$tgltrans1=$_REQUEST["tglminta"];
$tgltrans=explode("-",$tgltrans1);
$tglminta=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0];
$no_minta=$_REQUEST["no_minta"];
$no_minta_cetak=$no_minta;
$fdata=$_REQUEST["fdata"];
$idminta=$_REQUEST["idminta"];
$isview=$_REQUEST["isview"];
//======================Tanggalan==========================
$idgudang=$_SESSION["ses_id_gudang"];
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
		$arfdata=explode("**",$fdata);
		for ($i=0;$i<count($arfdata);$i++){
			$arfvalue=explode("|",$arfdata[$i]);
			$sql="insert into a_minta_obat(unit_id,user_id,no_bukti,obat_id,kepemilikan_id,qty,qty_terima,tgl,tgl_act,status) values($idunit,$iduser,'$no_minta',$arfvalue[0],$arfvalue[1],$arfvalue[2],0,'$tglminta','$tglact',0)";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
		}
		/*echo "<script>location='?f=list_minta_obat.php'</script>";*/
		//header("Location: ?f=list_minta_obat.php");
		break;
/* 	case "edit":
		$sql="update a_unit set UNIT_NAME='$unit_name',UNIT_TIPE='$unit_tipe',UNIT_ISAKTIF=$unit_isaktif where UNIT_ID=$unit_id";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		break;
*/
	case "delete":
		$sql="select ID from a_penerimaan where FK_MINTA_ID=$idminta and UNIT_ID_TERIMA=$idunit and TIPE_TRANS=1";
		$rs=mysqli_query($konek,$sql);
		if ($rows=mysqli_fetch_array($rs)){
			echo "<script>alert('Data Tdk Boleh Dihapus Karena Permintaan Obat Tersebut Sudah Dikirim !');</script>";
		}else{
			$sql="delete from a_minta_obat where permintaan_id=$idminta";
			$rs1=mysqli_query($konek,$sql);
			//echo $sql;
		}
		break;
}

$qry="select * from a_kepemilikan where AKTIF=1";
$exe=mysqli_query($konek,$qry);
$sela="";
$i=0;
while($show=mysqli_fetch_array($exe)){
	$sela .="sel.options[$i] = new Option('".$show['NAMA']."', '".$show['ID']."');";
	$i++;
}

//Aksi Save, Edit, Delete Berakhir ====================================
$sql="select * from a_minta_obat where unit_id=$idunit and month(tgl)=$bulan and year(tgl)=$th[2] order by permintaan_id desc limit 1";
$rs1=mysqli_query($konek,$sql);
if ($rows1=mysqli_fetch_array($rs1)){
	$no_minta=$rows1["no_bukti"];
	$ctmp=explode("/",$no_minta);
	$dtmp=$ctmp[3]+1;
	$ctmp=$dtmp;
	for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
	$no_minta="$kodeunit/UP/$th[2]-$th[1]/$ctmp";
}else{
	$no_minta="$kodeunit/UP/$th[2]-$th[1]/0001";
}
//echo $no_minta."<br>";
//mysqli_free_result($rs1);
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
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
			Request('../transaksi/obatlist_minta.php?aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSubmit(){
var cdata='';
var ctemp;
	if (document.forms[0].no_minta.value==""){
		alert('Isikan No Permintaan Terlebih Dahulu !');
		document.forms[0].no_minta.focus();
		return false;		
	}
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			ctemp=document.forms[0].obatid[i].value;
/*			if ((ctemp[1]*1)<(document.forms[0].txtJml[i].value*1)){
				document.forms[0].txtObat[i].focus();
				alert('Stok Obat Kurang !');
				return false;
			}
*/
			if (document.forms[0].obatid[i].value==""){
				alert('Pilih Obat Terlebih Dahulu !');
				document.forms[0].txtObat[i].focus();
				return false;		
			}			
			cdata +=ctemp+'|'+document.forms[0].kp_id[i].value+'|'+document.forms[0].txtJml[i].value+'**';
		}
		if (cdata!='') cdata=cdata.substr(0,cdata.length-2);
/*		for (var i=0;i<document.forms[0].obatid.length-1;i++){
			for (var j=i+1;j<document.forms[0].obatid.length-1;j++){
				
			}
			//alert(document.forms[0].obatid[i].value+'-'+document.forms[0].txtJml[i].value+'-'+document.forms[0].txtHarga[i].value);		
		}
*/
	}else{
		if (document.forms[0].obatid.value==""){
			alert('Pilih Obat Terlebih Dahulu !');
			document.forms[0].txtObat.focus();
			return false;		
		}
		ctemp=document.forms[0].obatid.value;
/*		if ((ctemp[1]*1)<(document.forms[0].txtJml.value*1)){
			document.forms[0].txtObat.focus();
			alert('Stok Obat Kurang !');
			return false;
		}
*/
		cdata=ctemp+'|'+document.forms[0].kp_id.value+'|'+document.forms[0].txtJml.value;
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
//	}else{
//		HitungSubTot(par);
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
  	row.className = 'itemtableA';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableAMOver';};
	row.onmouseout = function(){this.className='itemtableA';};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration-2);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);
  
  // right cell
  cellLeft = row.insertCell(1);
  textNode = document.createTextNode('-');
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
  
  // right cell
  var cellRight = row.insertCell(2);
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
  el.size = 87;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
  // select cell
  cellRight = row.insertCell(4);
  var sel;
  if(!isIE){
  	sel = document.createElement('select');
  	sel.name = 'kp_id';
  }else{
  	sel = document.createElement('<select name="kp_id" />');
  }	
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
  <?php echo $sela; ?>
  cellRight.className = 'tdisi';
  cellRight.appendChild(sel);

  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtJml';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
  }else{
  	el = document.createElement('<input name="txtJml" onKeyUp="AddRow(event,this)" />');
  }
  el.type = 'text';
  el.size = 5;
  el.className = 'txtcenter';
  
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
	  //HitungTot();
  }
}

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	//alert(par);
	if ((cdata[0]*1)==0){
		document.forms[0].obatid.value=cdata[1];
		document.forms[0].txtObat.value=cdata[2];
		tds = tbl.rows[3].getElementsByTagName('td');
		//document.forms[0].txtHarga.value=cdata[4];
		document.forms[0].txtJml.focus();
	}else{
/*		var w;
		for (var x=0;x<document.forms[0].obatid.length-1;x++){
			w=document.forms[0].obatid[x].value;
			//alert(cdata[1]+'-'+w);
			if (cdata[1]==w){
				fKeyEnt=true;
				alert("Obat Tersebut Sudah Ada");
				return false;
			}
		}
*/
		document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1];
		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[2];
		tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
		document.forms[0].txtJml[(cdata[0]*1)-1].focus();
	}
	tds[1].innerHTML=cdata[4];
	tds[3].innerHTML=cdata[3];

	document.getElementById('divobat').style.display='none';
}
</script>
</head>
<body onLoad="document.form1.txtObat.focus()">
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tgl_ctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 10px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="isview" id="isview" type="hidden" value="<?php echo $isview; ?>">
  <input name="idminta" id="idminta" type="hidden" value="">
  <?php if (($act=="save")||($isview=="true")){?>
  <input name="no_minta" id="no_minta" type="hidden" value="<?php echo $no_minta_cetak; ?>">
  <input name="tglminta" id="tglminta" type="hidden" value="<?php echo $tgltrans1; ?>">
  <?php }?>
  <input name="fdata" id="fdata" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
<?php if ($isview=="true"){?>
	<div id="idArea" style="display:block">
		<link rel="stylesheet" href="../theme/print.css" type="text/css" />
		  <p align="center"><span class="jdltable">PERMINTAAN OBAT KE GUDANG</span> </p>
		  <table width="41%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
			<tr>
			  <td width="162">Unit</td>
			  <td width="261">: <?php echo $namaunit; ?></td>
			</tr><tr>
			  <td width="162">Username</td>
			  <td width="261">:
			  <?php $sql="select username from a_minta_obat inner join a_user on a_minta_obat.user_id=a_user.kode_user where no_bukti='$no_minta_cetak'";
			  //echo $sql;
			  	$rs=mysqli_query($konek,$sql);
				$show=mysqli_fetch_array($rs);
				echo $user=$show['username']; ?></td>
			</tr>
				  <tr>
			  <td>Tgl Permintaan</td>
			  <td>: <?php echo $tgltrans1;?></td>
			</tr>
			<tr>
			  <td>No Permintaan </td>
			  <td>: <?php echo $no_minta_cetak; ?></td>
			</tr>
	  </table>
		  <table width="99%" border="0" cellpadding="1" cellspacing="0">
		<tr class="headtable"> 
		  <td width="30" height="25" class="tblheaderkiri">No</td>
		  <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
			Obat</td>
		  <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
			Obat</td>
		  <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
		  <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
		  <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
			Minta</td>
		</tr>
		<?php 
		  if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
		  }
		  if ($sorting=="") $sorting=$defaultsort;
		  $sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.qty,NAMA from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID where am.unit_id='$idunit' and am.no_bukti='$no_minta_cetak'".$filter." order by ".$sorting;
		  //echo $sql."<br>";
/*			$rs=mysqli_query($konek,$sql);
			$jmldata=mysqli_num_rows($rs);
			if ($page=="" || $page=="0") $page="1";
			$perpage=50;$tpage=($page-1)*$perpage;
			if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
			if ($page>1) $bpage=$page-1; else $bpage=1;
			if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
			$sql=$sql." limit $tpage,$perpage";
			//echo $sql."<br>";
*/
		  $rs=mysqli_query($konek,$sql);
		  $i=0;
		  //$i=($page-1)*$perpage;
		  $arfvalue="";
		  while ($rows=mysqli_fetch_array($rs)){
			$i++;
		  ?>
		<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
		  <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
		  <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty']; ?></td>
		  
		</tr>
		<?php 
		  }
		  mysqli_free_result($rs);
		  ?>
	  </table>
	  </div>
	<p align="center">
	<BUTTON type="button" onClick="PrintArea('idArea','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Permintaan&nbsp;&nbsp;</BUTTON>
	&nbsp;
    <BUTTON type="button" onClick="location='?f=list_minta_obat.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar Minta Obat &nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
  </p>

<?php }else{?>
	<div id="idArea" style="display:none">
		<link rel="stylesheet" href="../theme/print.css" type="text/css" />
		  <p align="center"><span class="jdltable">PERMINTAAN OBAT KE GUDANG</span> </p>
		  <table width="41%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
			<tr>
			  <td width="162">Unit</td>
			  <td width="261">: <?php echo $namaunit; ?></td>
			</tr><tr>
			  <td width="162">Username</td>
			  <td width="261">:
			  <?php $sql="select username from a_minta_obat inner join a_user on a_minta_obat.user_id=a_user.kode_user where no_bukti='$no_minta_cetak'";
			  //echo $sql;
			  	$rs=mysqli_query($konek,$sql);
				$show=mysqli_fetch_array($rs);
				echo $user=$show['username']; ?></td>
			</tr>
				  <tr>
			  <td>Tgl Permintaan</td>
			  <td>: <?php echo $tgltrans1;?></td>
			</tr>
			<tr>
			  <td>No Permintaan </td>
			  <td>: <?php echo $no_minta_cetak; ?></td>
			</tr>
	  </table>
		  <table width="99%" border="0" cellpadding="1" cellspacing="0">
		<tr class="headtable"> 
		  <td width="30" height="25" class="tblheaderkiri">No</td>
		  <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
			Obat</td>
		  <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
			Obat</td>
		  <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
		  <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
		  <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
			Minta</td>
		</tr>
		<?php 
		  if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
		  }
		  if ($sorting=="") $sorting=$defaultsort;
		  $sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.qty,NAMA from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID where am.unit_id='$idunit' and am.no_bukti='$no_minta_cetak'".$filter." order by ".$sorting;
		  $rs=mysqli_query($konek,$sql);
		  $i=0;
		  $arfvalue="";
		  while ($rows=mysqli_fetch_array($rs)){
			$i++;
		  ?>
		<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
		  <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
		  <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty']; ?></td>
		  
		</tr>
		<?php 
		  }
		  mysqli_free_result($rs);
		  ?>
	  </table>
	  </div>
	<?php if ($act=="save"){ ?>
  <p align="center"><b>Permintaan Obat ke Gudang Dgn No Bukti : <?php echo $no_minta_cetak; ?> Sudah Disimpan</b></p>
	<p align="center">
	<BUTTON type="button" onClick="PrintArea('idArea','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Permintaan&nbsp;&nbsp;</BUTTON>
	&nbsp;
    <BUTTON type="button" onClick="location='?f=list_minta_obat.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar Minta Obat &nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
  </p>
 	 <?php }else{ ?>

<script>
var arrRange=depRange=[];
</script>
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
	  <table width="99%" border="1">
	  	<tr>
			<td>
  			<div id="input" style="display:block" align="center"> 
            <table width="50%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
              <tr> 
                <td width="125">Unit&nbsp; </td>
                <td>: <?php echo $namaunit; ?></td>
              </tr>
              <tr> 
                <td width="125">Tanggal&nbsp; </td>
                <td>: 
                  <input name="tglminta" type="text" id="tglminta" size="11" maxlength="10" readonly="true" value="<?php echo $tgl;?>" class="txtcenter" /> 
                <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tglminta,depRange);" /></td>
              </tr>
              <tr> 
                <td>No. Permintaan</td>
                <td>: 
                  <input name="no_minta" type="text" class="txtinput" id="no_minta" value="<?php echo $no_minta; ?>" size="25" maxlength="30" readonly="true" ></td>
              </tr>
            </table>
  </div>
          <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr> 
              <td colspan="7" align="center" class="jdltable"><hr></td>
            </tr>
            <tr> 
              <td colspan="6" align="center" class="jdltable">PERMINTAAN OBAT 
                KE GUDANG</td>
              <td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
            </tr>
            <tr class="headtable"> 
              <td width="25" height="25" class="tblheaderkiri">No</td>
              <td width="100" height="25" class="tblheader">Kode Obat</td>
              <td height="25" class="tblheader">Nama Obat</td>
              <td width="100" height="25" class="tblheader">Satuan</td>
              <td width="100" class="tblheader">Kepemilikan</td>
              <td width="40" height="25" class="tblheader">Qty</td>
              <td width="30" height="25" class="tblheader">Proses</td>
            </tr>
            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
              <td class="tdisikiri">1</td>
              <td class="tdisi">-</td>
              <td class="tdisi" align="left"> <input name="obatid" type="hidden" value=""> 
                <input name="kp_asal" type="hidden" value=""> 
                <input type="text" name="txtObat" class="txtinput" size="87" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
              <td class="tdisi">-</td>
              <td class="tdisi"> <select name="kp_id" id="kp_id" class="txtinput">
                  <?
					  $qry="Select * from a_kepemilikan where aktif=1";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                  <option value="<?php echo $show['ID']; ?>" class="txtinput"<?php if ($kepemilikan_id==$show['ID']) echo " selected";?>> 
                  <?=$show['NAMA'];?>
                  </option>
                  <? }?>
                </select> </td>
              <td class="tdisi" width="40"> <input type="text" name="txtJml" class="txtcenter" size="5" onKeyUp="AddRow(event,this)" /></td>
              <td width="40" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
            </tr>
          </table>
		</td>
	</tr>
</table>
		<p align="center">
            <BUTTON type="button" onClick="fSubmit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
            &nbsp;<BUTTON type="reset" onClick="location='?f=list_minta_obat.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
<?php 
	}
} 
?>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>