<?php 
include("../sesi.php");

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$idunit = $_SESSION["ses_idunit"];
$namaunit = $_SESSION["ses_namaunit"];
$kodeunit = $_SESSION["ses_kodeunit"];
$iduser = $_SESSION["iduser"];
$unit_tipe = $_SESSION["ses_unit_tipe"];
$kategori = $_SESSION["kategori"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	header("Location: ../../index.php");
	exit();
}
//==============================================================
if ($unit_tipe<>4){
	header("Location: ../../index.php");
	exit();
}
// Koneksi =================================
include("../koneksi/konek.php");
//==========================================
//======================Tanggalan==========================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";

$tglhapus1=$_REQUEST["tglhapus"];
$tglhapus=explode("-",$tglhapus1);
$tglhapus=$tglhapus[2]."-".$tglhapus[1]."-".$tglhapus[0];
$nohapus=$_REQUEST["nohapus"];
$nohapusPrint=$nohapus;
$idunit_url=$_REQUEST['idunit']; if($_REQUEST['idunit']=="") $idunit_url=0; 
$txtAlasan=$_REQUEST['txtAlasan'];
$fdata=$_REQUEST["fdata"];


//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;
switch ($act){
	case "save":
		$arfdata=explode("**",$fdata);
		for ($i=0;$i<count($arfdata);$i++)
		{
			$arfvalue=explode("|",$arfdata[$i]);
			//echo $arfvalue[0]."-".$arfvalue[1]."-".$arfvalue[2]."-".$arfvalue[3]."<br>";
			$sql="insert into a_obat_hapus(ID_HAPUS,NO_HAPUS,TGL_HAPUS,TGL_ACT,PENERIMAAN_ID,UNIT_ID,OBAT_ID,QTY,ALASAN)
			values('','$nohapus','$tglhapus','$tglact','$arfvalue[3]',$idunit_url,$arfvalue[0],$arfvalue[1],'$arfvalue[2]')";
			//echo $sql."<br>";
			$rs1=mysqli_query($konek,$sql);
				
			//Karena obat dihapus, Kurangi Qty Stok pada penerimaan dg id_penerimaan yang ada=========
			$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$arfvalue[1] where ID=$arfvalue[3]";
			//echo $sql."<br>";
			$rs1=mysqli_query($konek,$sql); 
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ====================================
	$sql="select * from a_obat_hapus order by NO_HAPUS desc limit 1";
	//echo $sql;
	$rs=mysqli_query($konek,$sql);
	$nohapus="000001";
	$no_kunj="";
	$shft=1;
	if ($rows=mysqli_fetch_array($rs)){
		$nohapus=(int)$rows["NO_HAPUS"]+1;
		$nohapusstr=(string)$nohapus;
		if (strlen($nohapusstr)<6){
			for ($i=0;$i<(6-strlen($nohapusstr));$i++) $nohapus="0".$nohapus;
		}
	}
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script language="JavaScript" type="text/JavaScript">
var RowIdx;
var fKeyEnt;
function suggest(e,par){
var keywords=par.value;
	//alert(keywords);
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
			Request('../transaksi/obatlist_hapus.php?idunit=<?php echo $idunit_url; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSubmit(){
var cdata='';
var ctemp;
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			ctemp=document.forms[0].obatid[i].value.split('|');
			cdata +=ctemp[0]+'|'+document.forms[0].txtHapusStok[i].value+'|'+document.forms[0].txtAlasan[i].value+'|'+document.forms[0].idPenerimaan[i].value+'**';
		}
		if (cdata!='') cdata=cdata.substr(0,cdata.length-2);
	}else{
		ctemp=document.forms[0].obatid.value.split('|');
		cdata=ctemp[0]+'|'+document.forms[0].txtHapusStok.value+'|'+document.forms[0].txtAlasan.value+'|'+document.forms[0].idPenerimaan.value;
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
  el.size = 75;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellLeft = row.insertCell(2);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);

  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);


  cellLeft = row.insertCell(4);
  textNode2 = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode2);

  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtHapusStok';
	el.setAttribute('autocomplete', "off");
	//el.setAttribute('readonly', "false");
  }else{
  	el = document.createElement('<input name="txtHapusStok" readonly="false" />');
  }
  el.type = 'text';
  //el.id = 'txtJmlStok'+(iteration-1);
  el.size = 5;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
    // right cell
  cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtAlasan';
	el.setAttribute('autocomplete', "off");
	//el.setAttribute('readonly', "false");
  }else{
  	el = document.createElement('<input name="txtAlasan" readonly="false" />');
  }
  el.type = 'text';
  //el.id = 'txtJmlStok'+(iteration-1);
  el.size = 35;
  el.className = 'txtinput';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  // right cell
  cellRight = row.insertCell(7);
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
  
    // right cell
  cellRight = row.insertCell(8);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'idPenerimaan';
	el.setAttribute('autocomplete', "off");
	//el.setAttribute('readonly', "false");
  }else{
  	el = document.createElement('<input name="idPenerimaan" readonly="false" type="hidden" />');
  }
  el.type = 'hidden';
  //el.id = 'txtJmlStok'+(iteration-1);
  el.size = 35;
  el.className = 'txtinput';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  document.forms[0].txtObat[iteration-3].focus();
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
		document.forms[0].idPenerimaan.value=cdata[6];
		//document.forms[0].txtJml.focus();
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
		document.forms[0].idPenerimaan[(cdata[0]*1)-1].value=cdata[6];
		//document.forms[0].txtJml[(cdata[0]*1)-1].focus();
	}
	tds[2].innerHTML=cdata[3];
	tds[3].innerHTML=cdata[4];
	tds[4].innerHTML=cdata[5];

	document.getElementById('divobat').style.display='none';
}
</script>
</head>
<body onLoad="document.form1.no_kunj.focus()">
<div align="center">
<script>
var arrRange=depRange=[];
</script>
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<?php include("header.php");?>

<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tblbody">
<tr align="center" valign="top">
	<td align="center" height="450">
<?php if($act=='save') {?>

<!-- UNTUK DI PRINT OUT -->
<div align="center">
<div id="idArea" style="display:none;" align="center">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
			  <p align="center"><span class="jdltable">DAFTAR PENGHAPUSAN OBAT</span></p>
			  <table width="45%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
                
                <tr> 
                  <td width="308">Tanggal Hapus </td>
                  <td width="348">: <?php echo $tglhapus1; ?></td>
                </tr>
                <tr> 
                  <td>Unit</td>
				  <?php
				  $qry1=mysqli_query($konek,"SELECT UNIT_NAME FROM a_unit WHERE UNIT_ID=$idunit_url");
				  $show1=mysqli_fetch_array($qry1);
				  ?>
                  <td>: <?php echo $show1['UNIT_NAME']; ?></td>
                </tr>
                <tr>
                  <td>No. Penghapusan </td>
                  <td>: <?php echo $nohapus; ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
			  <table width="750" border="0" cellpadding="1" cellspacing="0" align="center">
                <tr class="headtable"> 
                  <td width="62" class="tblheaderkiri">No</td>
                  <td width="224" class="tblheader">Nama Obat</td>
                  <td width="142" class="tblheader">Satuan</td>
                  <td width="66" class="tblheader">Jml Stok</td>
				  <td width="246" class="tblheader">Alasan</td>
                </tr>
                <?php 
			  $sql="Select a_obat_hapus.OBAT_ID, a_obat_hapus.QTY, a_obat_hapus.ALASAN, a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL From a_obat_hapus
			  Inner Join a_obat ON a_obat_hapus.OBAT_ID = a_obat.OBAT_ID where NO_HAPUS='$nohapusPrint' order by ID_HAPUS";
			  //echo $sql."<br>";
			  $rs=mysqli_query($konek,$sql);
			  $i=0;
			  while ($rows=mysqli_fetch_array($rs)){
				$i++;
			  ?>
                <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
                  <td class="tdisikiri"><?php echo $i; ?></td>
                  <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['QTY']; ?></td>
				  <td class="tdisi" align="center"><?php echo $rows['ALASAN']; ?></td>
                </tr>
                <?php 
			  }
			  mysqli_free_result($rs);
			  ?>
              </table>
	</div>
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
<!--font size="24">UNDER CONSTRUCTION</font-->
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
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
            <table width="35%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
              <tr>
                <td width="49%">No. Penghapusan </td>
                <td width="51%"><input name="nohapus" type="text" id="nohapus" size="6" maxlength="6" value="<?php echo $nohapus;?>" class="txtinput" readonly="true" /></td>
                </tr>
              <tr>
                <td>Tanggal&nbsp; </td>
                <td><input name="tglhapus" type="text" id="tglhapus" size="11" maxlength="10" value="<?php echo $tgl;?>" class="txtcenter" /></td>
                </tr>
              <tr>
                <td>Unit</td>
                <td><select name="idunit" id="idunit" class="txtinput" onChange="location='hapus_obat.php?idunit='+idunit.value">
                    <option value="" class="txtinput"> Pilih Unit</option>
                    <?php
				  $qry="Select a_penerimaan.UNIT_ID_TERIMA, a_unit.UNIT_NAME From a_penerimaan
				  Inner Join a_unit ON a_penerimaan.UNIT_ID_TERIMA = a_unit.UNIT_ID where a_unit.UNIT_TIPE<>4 and a_penerimaan.STATUS=1
				  group by UNIT_ID_TERIMA";
				  $exe=mysqli_query($konek,$qry);
				  $i=0;
				  while($show=mysqli_fetch_array($exe)){ 
				  ?>
                    <option value="<?php echo $show['UNIT_ID_TERIMA'];?>" class="txtinput"<?php if ($_GET['idunit']==$show['UNIT_ID_TERIMA']) echo "selected";?>> <?php echo $show['UNIT_NAME'];?></option>
                    <? }?>
                </select></td> 
                </tr>
            </table>
  </div>
  <table id="tblJual" width="95%" border="0" cellpadding="0" cellspacing="0" align="center">
  	<tr>
		<td colspan="8" align="center" class="jdltable"><hr></td>
	</tr>
  	<tr>
		<td colspan="7" align="center" class="jdltable">DAFTAR PENGHAPUSAN OBAT</td>
		<td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
	</tr>
      <tr class="headtable">
        <td width="27" class="tblheaderkiri">No</td>
		<td width="470" class="tblheader">Nama Obat</td>
		<td width="49" class="tblheader">Kepemilikan</td>
		<td width="49" class="tblheader">Satuan</td>
		<td width="35" class="tblheader">Jml Stok </td>
		<td width="77" class="tblheader">Jml Hapus Obat  </td>
		<td width="231" class="tblheader">Alasan</td>
		<td class="tblheader" width="46">Proses</td>
      </tr>
	  <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
		<td class="tdisikiri" width="27">1</td>
		<td class="tdisi" align="left"><input name="obatid" type="hidden" value="">
		  <input type="text" name="txtObat" id="txtObat" class="txtinput" size="75" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
		      <td class="tdisi" width="49">-</td>
		      <td class="tdisi" width="49">-</td>
		      <td class="tdisi" width="35">-</td>
		      <td class="tdisi" width="77"><input type="text" name="txtHapusStok" id="txtHapusStok" class="txtright" size="5" /></td>
		      <td class="tdisi" width="231"><input name="txtAlasan" id="txtAlasan" size="34"></td>
		      <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}">
			  <input name="idPenerimaan" id="idPenerimaan" type="hidden" size="34"></td>
	  </tr>
  </table>
  
    </table>
    <table width="82%" border="0" cellpadding="0" cellspacing="0">
      <tr> 
        <td width="100%" align="center"><p>

			<BUTTON type="button" onClick="if (ValidateForm('tglhapus,nohapus,idunit,txtHapusStok,txtAlasan','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>

        <BUTTON type="reset" onClick="fSetBatalFr();location='?f=../transaksi/penjualan.php';"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Reset&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON> <br>
		<a class="navText" href='#' onclick='PrintArea("idArea","#")'>
		<BUTTON style="margin-top:10px;" type="button" <?php  if($act<>'save') echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak Penjualan</BUTTON></a>
			
          </p></td>
      </tr>
    </table>
</form>
</div>
		</td>
	</tr>
</table>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>